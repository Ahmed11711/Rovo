<?php

namespace App\Livewire\RestaurantPayment;

use Livewire\Component;

class RestaurantPaymentList extends Component
{

    public $search;
    
    public function render()
    {
        return view('livewire.restaurant-payment.restaurant-payment-list');
    }

}
