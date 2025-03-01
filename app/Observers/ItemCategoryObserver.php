<?php

namespace App\Observers;

use App\Models\ItemCategory;

class ItemCategoryObserver
{

    public function creating(ItemCategory $itemCategory)
    {
        if (branch()) {
            $itemCategory->branch_id = branch()->id;
        }
    }

}
