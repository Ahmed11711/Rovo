<?php

namespace App\Observers;

use App\Models\Kot;

class KotObserver
{

    public function creating(Kot $kot)
    {
        if (branch() && $kot->branch_id == null) {
            $kot->branch_id = branch()->id;
        }
    }

}
