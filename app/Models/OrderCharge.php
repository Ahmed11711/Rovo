<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCharge extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function charge()
    {
        return $this->belongsTo(RestaurantCharge::class, 'charge_id');
    }
}
