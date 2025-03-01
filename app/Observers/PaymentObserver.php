<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{

    public function creating(Payment $payment)
    {
        if (branch()) {
            $payment->branch_id = branch()->id;
        }
    }

}
