<?php

namespace App\Observers;

use App\Models\Reservation;

class ReservationObserver
{

    public function creating(Reservation $reservation)
    {
        if (branch()) {
            $reservation->branch_id = branch()->id;
        }
    }

}
