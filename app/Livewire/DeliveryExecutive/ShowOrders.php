<?php

namespace App\Livewire\DeliveryExecutive;

use Livewire\Component;

class ShowOrders extends Component
{

    public $customer;

    public function render()
    {
        return view('livewire.delivery-executive.show-orders');
    }

}
