<?php

namespace App\Livewire\RestaurantPayment;

use App\Models\RestaurantPayment;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class RestaurantPaymentTable extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $search;

    protected $listeners = ['refreshPayments' => '$refresh'];
    
    public function render()
    {
        $query = RestaurantPayment::where(function($q) {
                return $q->where('amount', 'like', '%'.$this->search.'%')->orWhere('transaction_id', 'like', '%'.$this->search.'%');
        })
        ->with('restaurant', 'package', 'package.currency')
        ->where('status', 'paid')
        ->orderBy('id', 'desc')
        ->paginate(20);

        return view('livewire.restaurant-payment.restaurant-payment-table', [
            'payments' => $query
        ]);
    }

}
