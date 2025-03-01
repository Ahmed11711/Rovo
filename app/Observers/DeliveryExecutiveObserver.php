<?php

namespace App\Observers;

use App\Models\DeliveryExecutive;

class DeliveryExecutiveObserver
{

    public function creating(DeliveryExecutive $deliveryExecutive)
    {
        if (branch()) {
            $deliveryExecutive->branch_id = branch()->id;
        }
    }

}
