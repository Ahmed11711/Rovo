<?php
namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;
use App\Models\Customer;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddCustomer extends Component
{
    use LivewireAlert;

    public $order;
    public $customerName;
    public $customerPhone;
    public $customerEmail;
    public $availableResults = [];
    public $customerAddress;
    public $showAddCustomerModal = false;

    #[On('showAddCustomerModal')]
    public function showAddCustomer($id = null)
    {
        if (!is_null($id)) {
            $this->order = Order::find($id);
        }

        $this->showAddCustomerModal = true;
    }

    public function updatedCustomerName()
    {
        if (strlen($this->customerName) >= 2) {
            $this->availableResults = $this->fetchSearchResults();
        } else {
            $this->availableResults = [];
        }
    }

    public function fetchSearchResults()
    {

        $results = Customer::where('restaurant_id', restaurant()->id)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->customerName . '%')
                    ->orWhere('phone', 'like', '%' . $this->customerName . '%')
                    ->orWhere('email', 'like', '%' . $this->customerName . '%');
            })->get();

        return $results;
    }

    public function selectCustomer($customerId)
    {
        $customer = Customer::find($customerId);

        if ($customer) {
            $this->customerName = $customer->name;
            $this->customerPhone = $customer->phone;
            $this->customerEmail = $customer->email;
            $this->customerAddress = $customer->delivery_address;
            $this->resetSearch();
        }
    }

    public function submitForm()
    {
        $this->validate([
            'customerName' => 'required'
        ]);

        $existingCustomer = Customer::where('email', $this->customerEmail)->first();

        if ($existingCustomer) {
            $existingCustomer->update([
                'name' => $this->customerName,
                'phone' => $this->customerPhone,
                'delivery_address' => $this->customerAddress
            ]);
            $customer = $existingCustomer;
        } else {
            $customer = Customer::create([
                'name' => $this->customerName,
                'phone' => $this->customerPhone,
                'email' => $this->customerEmail,
                'delivery_address' => $this->customerAddress
            ]);
        }

        if (!is_null($this->order)) {
            $this->order->customer_id = $customer->id;
            $this->order->delivery_address = $this->customerAddress;
            $this->order->save();

            $this->dispatch('showOrderDetail', id: $this->order->id);
            $this->dispatch('refreshOrders');
            $this->dispatch('refreshPos');
        }

        $this->resetForm();
    }

    public function resetSearch()
    {
        $this->availableResults = [];
    }

    public function resetForm()
    {
        $this->customerName = '';
        $this->customerPhone = '';
        $this->customerEmail = '';
        $this->customerAddress = '';
        $this->showAddCustomerModal = false;
    }

    public function render()
    {
        return view('livewire.customer.add-customer');
    }
}
