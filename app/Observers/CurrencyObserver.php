<?php

namespace App\Observers;

use App\Models\Currency;

class CurrencyObserver
{

    public function creating(Currency $currency)
    {
        if (restaurant()) {
            $currency->restaurant_id = restaurant()->id;
        }
    }

}
