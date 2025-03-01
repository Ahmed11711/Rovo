<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Livewire\Component;

class DuePaymentList extends Component
{

    public $search;

    protected $listeners = ['refreshPayments' => '$refresh'];

    public function mount()
    {
        abort_if(!in_array('Payment', restaurant_modules()), 403);
        abort_if((!user_can('Show Payments')), 403);
    }
    
    public function render()
    {
        $query = Payment::where('payment_method', 'due')->sum('amount');
        
        return view('livewire.payments.due-payment-list', [
            'dueTotal' => $query
        ]);
    }

}
