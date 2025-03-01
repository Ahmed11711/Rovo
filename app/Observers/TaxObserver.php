<?php

namespace App\Observers;

use App\Models\Tax;

class TaxObserver
{

    public function creating(Tax $tax)
    {
        if (restaurant()) {
            $tax->restaurant_id = restaurant()->id;
        }
    }

}
