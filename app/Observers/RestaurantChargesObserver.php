<?php

namespace App\Observers;

use App\Models\RestaurantCharge;

class RestaurantChargesObserver
{
    /**
     * Handle the RestaurantCharges "creating" event.
     */
    public function creating(RestaurantCharge $restaurantCharges): void
    {
        if (restaurant()) {
            $restaurantCharges->restaurant_id = restaurant()->id;
        }
    }
}
