<?php

namespace App\Models;

use App\Traits\HasRestaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantCharge extends Model
{
    use HasFactory;
    use HasRestaurant;

    protected $guarded = ['id'];

    protected $casts = [
        'order_types' => 'array',
    ];
}
