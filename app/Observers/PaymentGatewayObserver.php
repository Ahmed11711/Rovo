<?php

namespace App\Observers;

use App\Models\PaymentGatewayCredential;

class PaymentGatewayObserver
{

    public function creating(PaymentGatewayCredential $paymentGatewayCredential)
    {
        if (restaurant()) {
            $paymentGatewayCredential->restaurant_id = restaurant()->id;
        }
    }

}
