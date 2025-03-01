<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PaymentsTable extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $search;

    protected $listeners = ['refreshPayments' => '$refresh'];

    public function render()
    {
        $query = Payment::with('order')
            ->where('payment_method', '<>', 'due')
            ->where(function($q) {
                return $q->where('amount', 'like', '%'.$this->search.'%')->orWhere('transaction_id', 'like', '%'.$this->search.'%')->orWhere('payment_method', 'like', '%'.$this->search.'%');
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.payments.payments-table', [
            'payments' => $query
        ]);
    }

}
