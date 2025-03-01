<?php

namespace App\Observers;

use App\Models\MenuItem;

class MenuItemObserver
{

    public function creating(MenuItem $menuItem)
    {
        if (branch()) {
            $menuItem->branch_id = branch()->id;
        }
    }

}
