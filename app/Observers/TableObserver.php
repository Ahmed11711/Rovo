<?php

namespace App\Observers;

use App\Models\Table;

class TableObserver
{

    public function creating(Table $table)
    {
        if (branch()) {
            $table->branch_id = branch()->id;
        }
    }

}
