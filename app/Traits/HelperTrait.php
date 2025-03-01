<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\PaymentGatewayCredential;

trait HelperTrait
{

    public function throwValidationError(array $error)
    {
        throw \Illuminate\Validation\ValidationException::withMessages($error);
    }

}
