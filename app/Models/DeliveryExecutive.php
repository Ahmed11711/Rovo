<?php

namespace App\Models;

use App\Traits\HasBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryExecutive extends Model
{
    use HasBranch;

    protected $guarded = ['id'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->orderBy('id', 'desc');
    }

}
