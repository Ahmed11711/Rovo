<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{

    public function creating(Customer $customer)
    {
        if (restaurant()) {
            $customer->restaurant_id = restaurant()->id;
        }
    }

}
