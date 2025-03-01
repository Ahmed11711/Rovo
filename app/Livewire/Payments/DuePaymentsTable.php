<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class DuePaymentsTable extends Component
{

    use WithPagination, WithoutUrlPagination;

    protected $listeners = ['refreshPayments' => '$refresh'];

    public $search;

    public function showPayment($id)
    {
        $this->dispatch('showPaymentModal', id: $id);
    }

    public function render()
    {
        $query = Payment::with('order')
            ->join('orders', 'orders.id', 'payments.order_id')
            ->where('payment_method', 'due')
            ->where(function($q) {
                return $q->where('amount', 'like', '%'.$this->search.'%')->orWhere('order_id', 'like', '%'.$this->search.'%')->orWhere('orders.order_number', 'like', '%'.$this->search.'%');
            })
            ->select('payments.*', 'orders.order_number')
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return view('livewire.payments.due-payments-table', [
            'payments' => $query
        ]);
    }

}
