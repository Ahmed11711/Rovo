<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflinePaymentMethod extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    public function offlinePlanChanges()
    {
        return $this->hasMany(OfflinePlanChange::class, 'offline_method_id');
    }

}
