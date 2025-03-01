<?php

namespace App\Observers;

use App\Models\Area;

class AreaObserver
{

    public function creating(Area $area)
    {
        if (branch()) {
            $area->branch_id = branch()->id;
        }
    }

}
