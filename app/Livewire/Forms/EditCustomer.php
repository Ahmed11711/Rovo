<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Component;

class EditCustomer extends Component
{

    public $customer;
    public $customerName;
    public $customerEmail;
    public $customerPhone;

    public function mount()
    {
        $this->customerPhone = $this->customer->phone;
        $this->customerName = $this->customer->name;
        $this->customerEmail = $this->customer->email;
    }

    public function submitForm()
    {
        $this->validate([
            'customerEmail' => 'required|email'
        ]);

        $this->customer->name = $this->customerName;
        $this->customer->email = $this->customerEmail;
        $this->customer->phone = $this->customerPhone;
        $this->customer->save();

        $this->dispatch('refreshCustomers');
        $this->dispatch('hideEditCustomer');
    }
    
    public function render()
    {
        return view('livewire.forms.edit-customer');
    }

}
