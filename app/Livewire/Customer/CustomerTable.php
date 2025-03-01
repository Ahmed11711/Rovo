<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use App\Models\Order;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $search;
    public $customer;
    public $showEditCustomerModal = false;
    public $confirmDeleteCustomerModal = false;
    public $showCustomerOrderModal = false;

    protected $listeners = ['refreshCustomers' => '$refresh'];

    public function showEditCustomer($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->showEditCustomerModal = true;
    }

    public function showDeleteCustomer($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->confirmDeleteCustomerModal = true;
    }

    public function showCustomerOrders($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->showCustomerOrderModal = true;
    }

    public function deleteCustomer($id, $deleteOrder = false)
    {
        if ($deleteOrder) {
            Order::where('customer_id', $id)->delete();
        }

        Customer::destroy($id);

        $this->confirmDeleteCustomerModal = false;
        $this->dispatch('refreshOrders');

        $this->alert('success', __('messages.customerDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    #[On('hideEditCustomer')]
    public function hideEditCustomer()
    {
        $this->showEditCustomerModal = false;
    }

    public function render()
    {
        $query = Customer::withCount('orders');
              
        $query = $query->where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%')->orWhere('phone', 'like', '%'.$this->search.'%')->paginate(10);

        return view('livewire.customer.customer-table', [
            'customers' => $query
        ]);
    }

}
