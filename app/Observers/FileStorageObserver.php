<?php

namespace App\Observers;

use App\Models\FileStorage;

class FileStorageObserver
{

    public function creating(FileStorage $model)
    {
        if (restaurant()) {
            $model->restaurant_id = restaurant()->id;
        }
    }

}
