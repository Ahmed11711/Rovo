<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Models\Payment;
use App\Models\SplitOrder;
use App\Models\Table;
use App\Notifications\SendOrderBill;
use Livewire\Attributes\On;
use Livewire\Component;

class AddPayment extends Component
{
    public $order;
    public $showAddPaymentModal = false;
    public $paymentMethod = 'cash';
    public $paymentAmount = 0;
    public $returnAmount = 0;
    public $balanceAmount = 0;
    public $dueAmount = 0;
    public $paidAmount = 0;
    // Split payment properties
    public $showSplitOptions = false;
    public $splitType = null;
    public $numberOfSplits = 2;
    public $customSplits = [];
    public $splits = [];
    public $availableItems = [];
    public $activeSplitId = 1;

    #[On('showPaymentModal')]
    public function showPaymentModal($id)
    {
        $this->order = Order::with([
            'items',
            'items.menuItem',
            'taxes',
            'payments' => function($query) {
                $query->where('payment_method', '!=', 'due');
            }
        ])->find($id);

        $this->dueAmount = $this->order->total - $this->order->payments->sum('amount');
        $this->paymentAmount = $this->dueAmount;
        $this->balanceAmount = $this->dueAmount - $this->paymentAmount;
        $this->paidAmount = $this->order->payments->sum('amount');
        $this->returnAmount = 0;
        $this->showAddPaymentModal = true;

        // Initialize available items for split from order items
        $this->availableItems = $this->order->items->map(function($orderItem) {
            // Calculate item price including taxes
            $itemPrice = $orderItem->amount;

            // Calculate tax amount for this item based on order's total tax distribution
            $itemTaxAmount = 0;
            if ($this->order->total > 0) {
                foreach ($this->order->taxes as $item) {
                    $itemTaxAmount += (($item->tax->tax_percent / 100) * $itemPrice);
                }
            }

            $totalItemPrice = $itemPrice + $itemTaxAmount;

            return [
                'id' => $orderItem->id,
                'name' => $orderItem->menuItem->item_name,
                'quantity' => 1,
                'price' => $totalItemPrice,  // Price including taxes
                'base_price' => $itemPrice,  // Original price without taxes
                'tax_amount' => $itemTaxAmount,  // Calculated tax amount for this item
                'total' => $orderItem->total,
                'remaining' => 1,
                'order_item_id' => $orderItem->id
            ];
        })->toArray();

        $this->initializeSplits();
    }

    private function initializeSplits()
    {
        if ($this->splitType === 'items') {
            // Initialize with just one split for items split type
            $this->splits = [
                1 => [
                    'id' => 1,
                    'items' => [],
                    'paymentMethod' => 'cash',  // Initialize payment method for first split
                    'amount' => 0,
                    'total' => 0
                ]
            ];
            $this->activeSplitId = 1;
        } else {
            // Initialize splits for equal and custom split types
            $this->customSplits = [1, 2];

            // Initialize payment methods and amounts for all splits
            foreach ($this->customSplits as $splitNumber) {
                $this->splits[$splitNumber] = [
                    'id' => $splitNumber,
                    'paymentMethod' => 'cash',
                    'amount' => 0
                ];
            }

            // For equal splits, set initial amounts
            if ($this->splitType === 'equal' || is_null($this->splitType)) {
                $splitAmount = $this->order->total / $this->numberOfSplits;
                foreach ($this->splits as $i => $split) {
                    if ($i > 0) { // Skip index 0
                        $this->splits[$i]['amount'] = $splitAmount;
                    }
                }
            }
        }

        $this->balanceAmount = $this->dueAmount - $this->paymentAmount;
    }

    public function updatedPaymentAmount()
    {
        if ($this->paymentMethod === 'cash') {
            $paymentAmount = floatval($this->paymentAmount);

            if ($paymentAmount > $this->dueAmount) {
                // If payment is more than total, show return amount
                $this->returnAmount = $paymentAmount - $this->dueAmount;
                $this->balanceAmount = 0;
            } else {
                // If payment is less than total, show due amount
                $this->returnAmount = 0;
                $this->balanceAmount = $this->dueAmount - $paymentAmount;
            }
        } else {
            $this->paymentAmount = floatval($this->dueAmount);
            $this->balanceAmount = $this->dueAmount - $this->paymentAmount;
            $this->returnAmount = 0;
        }
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
        if ($method !== 'cash') {
            $this->paymentAmount = $this->dueAmount;
            $this->returnAmount = 0;
        } else {
            $this->updatedPaymentAmount(); // Recalculate return/due amounts for cash
        }
    }

    public function quickAmount($amount)
    {
        if ($this->paymentMethod === 'cash') {
            $this->paymentAmount = floatval($amount);
            $this->updatedPaymentAmount();
        }
    }

    public function appendNumber($number)
    {
        if ($this->paymentMethod !== 'cash') {
            return;
        }

        if ($number === '.' && str_contains((string)$this->paymentAmount, '.')) {
            return;
        }

        if ($this->paymentAmount === 0) {
            $this->paymentAmount = $number;
        } else {
            $this->paymentAmount = (string)$this->paymentAmount . $number;
        }

        $this->paymentAmount = floatval($this->paymentAmount);
        $this->updatedPaymentAmount();
    }

    public function clearAmount()
    {
        $this->paymentAmount = 0;
        $this->returnAmount = 0;
    }

    public function updateSplitPayment($splitId, $method)
    {
        if ($this->splitType === 'items') {
            $split = collect($this->splits)->firstWhere('id', $splitId);
            $split['paymentMethod'] = $method;
        }
    }

    public function processSplitPayment()
    {
        switch ($this->splitType) {
        case 'equal':
            $this->order->split_type = 'even';
            $this->order->saveQuietly();

            foreach ($this->splits as $i => $split) {
                if ($i > 0 && !empty($split['amount'])) { // Skip index 0 and empty amounts
                    SplitOrder::create([
                        'order_id' => $this->order->id,
                        'amount' => $split['amount'],
                        'payment_method' => $split['paymentMethod'],
                        'status' => 'paid'
                    ]);

                    Payment::create([
                        'order_id' => $this->order->id,
                        'payment_method' => $split['paymentMethod'],
                        'amount' => $split['amount']
                    ]);
                }
            }
                break;

        case 'custom':
            $this->order->split_type = 'custom';
            $this->order->saveQuietly();

            foreach ($this->customSplits as $split) {
                if (!empty($this->splits[$split]['amount'])) {
                    SplitOrder::create([
                        'order_id' => $this->order->id,
                        'amount' => $this->splits[$split]['amount'],
                        'payment_method' => $this->splits[$split]['paymentMethod'],
                        'status' => 'paid'
                    ]);

                    Payment::create([
                        'order_id' => $this->order->id,
                        'payment_method' => $this->splits[$split]['paymentMethod'],
                        'amount' => $this->splits[$split]['amount']
                    ]);
                }
            }
                break;

        case 'items':
            $this->order->split_type = 'items';
            $this->order->saveQuietly();

            foreach ($this->splits as $split) {
                if (!empty($split['items'])) {
                    $splitTotal = collect($split['items'])->sum(function($item) {
                        return floatval($item['price']) * intval($item['quantity']);
                    });

                    if ($splitTotal > 0) {
                        // Create split payment record
                        $payment = Payment::create([
                            'order_id' => $this->order->id,
                            'payment_method' => $split['paymentMethod'],
                            'amount' => $splitTotal
                        ]);

                        // Create split order record
                        $splitOrder = SplitOrder::create([
                            'order_id' => $this->order->id,
                            'amount' => $splitTotal,
                            'payment_method' => $split['paymentMethod'],
                            'status' => 'paid'
                        ]);

                        // Link items to split order
                        foreach ($split['items'] as $item) {
                            $splitOrder->items()->create([
                            'order_item_id' => $item['order_item_id']
                            ]);
                        }
                    }
                }
            }
                break;
        }
    }

    public function submitForm()
    {
        if ($this->showSplitOptions && $this->splitType) {
            $this->processSplitPayment();

        } else {
            if ($this->paymentAmount > 0) {
                Payment::create([
                'order_id' => $this->order->id,
                'payment_method' => $this->paymentMethod,
                'amount' => $this->paymentAmount - $this->returnAmount,
                'balance' => $this->returnAmount
                ]);
            }
        }
        $orderPaidAmount = Payment::where('order_id', $this->order->id)->where('payment_method', '!=', 'due')->sum('amount');

        $this->order->amount_paid = $orderPaidAmount;
        $this->order->status = $orderPaidAmount >= $this->order->total ? 'paid' : 'payment_due';
        $this->order->save();

        Payment::where('order_id', $this->order->id)->where('payment_method', 'due')->delete();

        if ($orderPaidAmount < $this->order->total) {
            Payment::create([
            'order_id' => $this->order->id,
            'payment_method' => 'due',
            'amount' => $this->order->total - $orderPaidAmount
            ]);
        }


        Table::where('id', $this->order->table_id)->update([
            'available_status' => 'available'
        ]);

        if ($this->order->customer_id) {
            $this->order->customer->notify(new SendOrderBill($this->order));
        }

        $this->dispatch('showOrderDetail', id: $this->order->id);
        $this->dispatch('refreshOrders');
        $this->dispatch('resetPos');
        $this->dispatch('refreshPayments');
        $this->showAddPaymentModal = false;
    }

    public function render()
    {
        return view('livewire.order.add-payment');
    }

    public function updateSplitPaymentMethod($splitId, $method)
    {
        if (isset($this->splits[$splitId])) {
            $this->splits[$splitId]['paymentMethod'] = $method;
            $this->splits = $this->splits; // Trigger Livewire update
        }
    }

    public function updateBalanceAmount()
    {
        if ($this->splitType === 'custom') {
            $totalSplitAmount = collect($this->splits)->sum('amount');
            $this->balanceAmount = $this->dueAmount - $totalSplitAmount;
        }
    }

    public function addItemToSplit($itemId, $splitId)
    {
        $item = collect($this->availableItems)->firstWhere('id', $itemId);
        if ($item && $item['remaining'] > 0) {
            // Add item to split with all necessary fields
            $splitItem = [
                'id' => $item['id'],
                'order_item_id' => $item['order_item_id'],
                'name' => $item['name'],
                'quantity' => 1,
                'price' => floatval($item['price']),
                'base_price' => floatval($item['base_price']),
                'tax_amount' => floatval($item['tax_amount']),
                'total' => floatval($item['price'])
            ];

            if (!isset($this->splits[$splitId]['items'])) {
                $this->splits[$splitId]['items'] = [];
            }

            // Check if item already exists in split
            $existingItemIndex = collect($this->splits[$splitId]['items'])->search(fn($i) => $i['order_item_id'] === $item['order_item_id']);

            if ($existingItemIndex !== false) {
                // Increment quantity if item exists
                $this->splits[$splitId]['items'][$existingItemIndex]['quantity']++;
                $this->splits[$splitId]['items'][$existingItemIndex]['total'] = $this->splits[$splitId]['items'][$existingItemIndex]['quantity'] * $this->splits[$splitId]['items'][$existingItemIndex]['price'];
            } else {
                // Add new item if it doesn't exist
                $this->splits[$splitId]['items'][] = $splitItem;
            }

            // Update remaining quantity
            $index = collect($this->availableItems)->search(fn($i) => $i['id'] === $itemId);
            $this->availableItems[$index]['remaining']--;

            // Update split total
            $this->calculateSplitTotals();
        }
    }

    public function removeItemFromSplit($splitId, $itemIndex)
    {
        if (isset($this->splits[$splitId]['items'][$itemIndex])) {
            $item = $this->splits[$splitId]['items'][$itemIndex];

            // Return item to available items
            $availableIndex = collect($this->availableItems)->search(fn($i) => $i['id'] === $item['id']);
            if ($availableIndex !== false) {
                $this->availableItems[$availableIndex]['remaining']++;
            }

            // Remove item from split
            unset($this->splits[$splitId]['items'][$itemIndex]);
            $this->splits[$splitId]['items'] = array_values($this->splits[$splitId]['items']);

            // Update split total
            $this->calculateSplitTotals();
        }
    }

    public function calculateSplitTotals()
    {
        foreach ($this->splits as &$split) {  // Note the & to modify the original array
            if (isset($split['items'])) {
                $split['total'] = collect($split['items'])->sum(function($item) {
                    return floatval($item['price']) * intval($item['quantity']);
                });
            }
        }
    }

    public function updatedSplits($value, $key)
    {
        if ($this->splitType === 'equal') {
            $totalSplitAmount = collect($this->splits)->sum('amount');
            $this->balanceAmount = $this->order->total - $totalSplitAmount;
        }
    }

    public function addNewSplit()
    {
        $this->numberOfSplits++;

        // Initialize the new split with default values
        $this->splits[$this->numberOfSplits] = [
            'id' => $this->numberOfSplits,
            'paymentMethod' => 'cash',
            'amount' => $this->order->total / $this->numberOfSplits
        ];

        // Recalculate all split amounts evenly
        $splitAmount = $this->order->total / $this->numberOfSplits;
        foreach ($this->splits as $i => $split) {
            if ($i > 0) { // Skip index 0
                $this->splits[$i]['amount'] = $splitAmount;
            }
        }

        $this->calculateBalanceAmount();
    }

    public function removeSplit($index)
    {
        if ($this->numberOfSplits > 2) {
            $this->numberOfSplits--;
            unset($this->splits[$index]);

            // Reindex the splits array
            $this->splits = array_values($this->splits);

            // Recalculate all split amounts evenly
            $splitAmount = $this->order->total / $this->numberOfSplits;
            foreach ($this->splits as $i => $split) {
                if ($i > 0) { // Skip index 0
                    $this->splits[$i]['amount'] = $splitAmount;
                }
            }

            $this->calculateBalanceAmount();
        }
    }

    private function calculateBalanceAmount()
    {
        $totalSplitAmount = collect($this->splits)->sum('amount');
        $this->balanceAmount = $this->order->total - $totalSplitAmount;
    }

    public function addNewCustomSplit()
    {
        $nextSplitNumber = max($this->customSplits) + 1;
        $this->customSplits[] = $nextSplitNumber;

        // Initialize the new split with default values
        $this->splits[$nextSplitNumber] = [
            'id' => $nextSplitNumber,
            'paymentMethod' => 'cash',
            'amount' => 0
        ];
    }

    public function removeCustomSplit($splitNumber)
    {
        if (count($this->customSplits) > 2) {
            // Remove from customSplits array
            $this->customSplits = array_values(array_filter($this->customSplits, function($split) use ($splitNumber) {
                return $split !== $splitNumber;
            }));

            // Remove from splits array
            unset($this->splits[$splitNumber]);

            $this->calculateBalanceAmount();
        }
    }

    public function addNewItemSplit()
    {
        $nextSplitId = max(array_keys($this->splits)) + 1;

        // Add new split with empty items array and its own payment method
        $this->splits[$nextSplitId] = [
            'id' => $nextSplitId,
            'items' => [],
            'paymentMethod' => 'cash',  // Each new split gets its own payment method
            'amount' => 0,
            'total' => 0
        ];

        $this->activeSplitId = $nextSplitId;
    }

    public function removeItemSplit($splitId)
    {
        if (count($this->splits) > 1) { // Keep at least one split
            // Return items to available pool
            if (isset($this->splits[$splitId]['items'])) {
                foreach ($this->splits[$splitId]['items'] as $item) {
                    $availableIndex = collect($this->availableItems)->search(fn($i) => $i['id'] === $item['id']);
                    if ($availableIndex !== false) {
                        $this->availableItems[$availableIndex]['remaining'] += $item['quantity'];
                    }
                }
            }

            // Remove the split
            unset($this->splits[$splitId]);

            // Reset active split to first split if removed split was active
            if ($this->activeSplitId === $splitId) {
                $this->activeSplitId = array_key_first($this->splits);
            }

            // Recalculate totals
            $this->calculateSplitTotals();
        }
    }

}

