<?php

namespace App\Livewire\Payments;

use Livewire\Component;

class PaymentList extends Component
{
    public $search;

    public function mount()
    {
        abort_if(!in_array('Payment', restaurant_modules()), 403);
        abort_if((!user_can('Show Payments')), 403);
    }

    public function render()
    {
        return view('livewire.payments.payment-list');
    }

}
