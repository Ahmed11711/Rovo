<?php

namespace App\Livewire\Order;

use App\Models\Kot;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTax;
use App\Models\Table;
use App\Models\Tax;
use App\Models\DeliveryExecutive;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderDetail extends Component
{

    use LivewireAlert;

    public $order;
    public $taxes;
    public $total = 0;
    public $subTotal = 0;
    public $showOrderDetail = false;
    public $showAddCustomerModal = false;
    public $showTableModal = false;
    public $cancelOrderModal = false;
    public $deleteOrderModal = false;
    public $tableNo;
    public $tableId;
    public $orderStatus;
    public $discountAmount = 0;
    public $deliveryExecutives;
    public $deliveryExecutive;

    public function mount()
    {
        $this->total = 0;
        $this->subTotal = 0;
        $this->taxes = Tax::all();
        $this->deliveryExecutives = DeliveryExecutive::where('status', 'available')->get();
        if ($this->order) {
            $this->deliveryExecutive = $this->order->delivery_executive_id;
        }
    }

    #[On('showOrderDetail')]
    public function showOrder($id)
    {
        $this->order = Order::with('items', 'items.menuItem', 'items.menuItemVariation')->find($id);
        $this->orderStatus = $this->order->status;
        $this->showOrderDetail = true;
    }

    #[On('setTable')]
    public function setTable(Table $table)
    {
        $this->tableNo = $table->table_code;
        $this->tableId = $table->id;

        if ($this->order) {
            $currentOrder = Order::where('id', $this->order->id)->first();

            Table::where('id', $currentOrder->table_id)->update([
                'available_status' => 'available'
            ]);

            $currentOrder->update(['table_id' => $table->id]);

            if ($this->order->date_time->format('d-m-Y') == now()->format('d-m-Y')) {
                Table::where('id', $this->tableId)->update([
                    'available_status' => 'running'
                ]);
            }

            $this->order->fresh();
            $this->dispatch('showOrderDetail', id: $this->order->id);
        }

        $this->dispatch('posOrderSuccess');
        $this->dispatch('refreshOrders');
        $this->dispatch('refreshPos');

        $this->showTableModal = false;
    }

    public function saveOrderStatus()
    {
        if ($this->order) {
            Order::where('id', $this->order->id)->update(['status' => $this->orderStatus]);

            $this->dispatch('posOrderSuccess');
            $this->dispatch('refreshOrders');
            $this->dispatch('refreshPos');
        }
    }

    #[On('showAddCustomerModal')]
    public function showAddCustomer($id)
    {
        $this->order = Order::find($id);
        $this->showAddCustomerModal = true;
    }

    public function deleteOrderItems($id)
    {
        OrderItem::destroy($id);

        if ($this->order) {
            $this->total = 0;
            $this->subTotal = 0;

            foreach ($this->order->items as $value) {
                $this->subTotal = ($this->subTotal + $value->amount);
                $this->total = ($this->total + $value->amount);
            }

            foreach ($this->taxes as $value) {
                $this->total = ($this->total + (($value->tax_percent / 100) * $this->subTotal));
            }

            Order::where('id', $this->order->id)->update([
                'sub_total' => $this->subTotal,
                'total' => $this->total
            ]);

        }

        $this->dispatch('refreshPos');
    }

    public function saveOrder($action)
    {

        switch ($action) {
        case 'bill':
            $successMessage = __('messages.billedSuccess');
            $status = 'billed';
            $tableStatus = 'running';
            break;

        case 'kot':
            return $this->redirect(route('pos.show', $this->order->table_id), navigate: true);
        }

        $taxes = Tax::all();

        Order::where('id', $this->order->id)->update([
            'date_time' => now(),
            'status' => $status
        ]);

        if ($status == 'billed') {

            foreach ($this->order->kot as $kot) {
                foreach ($kot->items as $item) {
                    $price = (($item->menu_item_variation_id) ? $item->menuItemVariation->price : $item->menuItem->price);
                    OrderItem::create([
                        'order_id' => $this->order->id,
                        'menu_item_id' => $item->menu_item_id,
                        'menu_item_variation_id' => $item->menu_item_variation_id,
                        'quantity' => $item->quantity,
                        'price' => $price,
                        'amount' => ($price * $item->quantity),
                    ]);
                }
            }

            foreach ($taxes as $value) {
                OrderTax::create([
                    'order_id' => $this->order->id,
                    'tax_id' => $value->id
                ]);
            }

            $this->total = 0;
            $this->subTotal = 0;

            foreach ($this->order->load('items')->items as $value) {
                $this->subTotal = ($this->subTotal + $value->amount);
                $this->total = ($this->total + $value->amount);
            }

            foreach ($taxes as $value) {
                $this->total = ($this->total + (($value->tax_percent / 100) * $this->subTotal));
            }

            if ($this->order->discount_type === 'percent') {
                $this->discountAmount = round(($this->subTotal * $this->order->discount_value) / 100, 2);
            } elseif ($this->order->discount_type === 'fixed') {
                $this->discountAmount = min($this->order->discount_value, $this->subTotal);
            }

            $this->total -= $this->discountAmount;

            Order::where('id', $this->orderDetail->id)->update([
                'sub_total' => $this->subTotal,
                'total' => $this->total,
                'discount_amount' => $this->discountAmount,
            ]);
        }

        Table::where('id', $this->tableId)->update([
            'available_status' => $tableStatus
        ]);


        $this->alert('success', $successMessage, [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        if ($status == 'billed') {
            $this->dispatch('showOrderDetail', id: $this->order->id);
            $this->dispatch('posOrderSuccess');
            $this->dispatch('refreshOrders');
            $this->dispatch('resetPos');
        }

    }

    public function showPayment($id)
    {
        $this->dispatch('showPaymentModal', id: $id);
    }

    public function cancelOrder($id)
    {
        Order::where('id', $id)->update(['status' => 'canceled']);
        Kot::where('order_id', $id)->delete();

        $this->cancelOrderModal = false;
        $this->dispatch('showOrderDetail', id: $this->order->id);
        $this->dispatch('posOrderSuccess');
        $this->dispatch('refreshOrders');
        $this->dispatch('resetPos');

        $this->alert('success', __('messages.orderCanceled'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);

        Order::destroy($id);

        $this->deleteOrderModal = false;
        $this->dispatch('refreshOrders');
        $this->dispatch('refreshPos');

        $this->dispatch('refreshKots');

        $this->showOrderDetail = false;

        $this->alert('success', __('messages.orderDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function saveDeliveryExecutive()
    {
        $this->order->update(['delivery_executive_id' => $this->deliveryExecutive]);
        $this->order->fresh();
        $this->alert('success', __('messages.deliveryExecutiveAssigned'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.order.order-detail');
    }

}
