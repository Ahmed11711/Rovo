<?php

namespace App\Observers;

use App\Models\Menu;

class MenuObserver
{

    public function creating(Menu $menu)
    {
        if (branch()) {
            $menu->branch_id = branch()->id;
        }
    }

}
