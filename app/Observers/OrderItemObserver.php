<?php

namespace App\Observers;

use App\Models\OrderItem;

class OrderItemObserver
{

    public function creating(OrderItem $orderItem)
    {
        if (branch() && $orderItem->branch_id == null) {
            $orderItem->branch_id = branch()->id;
        }
    }

}
