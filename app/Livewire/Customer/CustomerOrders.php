<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class CustomerOrders extends Component
{

    public $customer;
    
    public function render()
    {
        return view('livewire.customer.customer-orders');
    }

}
