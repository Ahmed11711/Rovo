<?php

namespace App\Observers;

use App\Models\ReservationSetting;

class ReservationSettingObserver
{

    public function creating(ReservationSetting $reservationSetting)
    {
        if (branch()) {
            $reservationSetting->branch_id = branch()->id;
        }
    }

}
