<?php

namespace App\Livewire\Dashboard;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TodayPaymentMethodEarnings extends Component
{

    public function render()
    {
        $paymentMethods = Payment::where('payment_method', '<>', 'due')
            ->select('payment_method', DB::raw('SUM(amount) as total_amount'))
            ->whereDate('created_at', today())
            ->groupBy('payment_method')
            ->get()->sortBy('total_amount', SORT_REGULAR, true);

        return view('livewire.dashboard.today-payment-method-earnings', ['paymentMethods' => $paymentMethods]);
    }

}
