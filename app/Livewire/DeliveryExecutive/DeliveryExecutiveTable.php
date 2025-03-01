<?php

namespace App\Livewire\DeliveryExecutive;

use App\Models\DeliveryExecutive;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class DeliveryExecutiveTable extends Component
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
        $this->customer = DeliveryExecutive::findOrFail($id);
        $this->showEditCustomerModal = true;
    }

    #[On('hideEditStaff')]
    public function hideEditStaff()
    {
        $this->showEditCustomerModal = false;
        $this->js('window.location.reload()');
    }

    public function showDeleteCustomer($id)
    {
        $this->customer = DeliveryExecutive::findOrFail($id);
        $this->confirmDeleteCustomerModal = true;
    }

    public function deleteCustomer($id)
    {
        DeliveryExecutive::destroy($id);

        $this->confirmDeleteCustomerModal = false;

        $this->alert('success', __('messages.memberDeleted'), [
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

    public function showCustomerOrders($id)
    {
        $this->customer = DeliveryExecutive::findOrFail($id);
        $this->showCustomerOrderModal = true;
    }

    public function render()
    {
        $query = DeliveryExecutive::withCount('orders')->where(function($q) {
            return $q->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('phone', 'like', '%'.$this->search.'%');
        })
        ->paginate(10);

        return view('livewire.delivery-executive.delivery-executive-table', [
            'members' => $query
        ]);
    }

}
