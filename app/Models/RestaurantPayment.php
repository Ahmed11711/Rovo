<?php

namespace App\Models;

use App\Traits\HasRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantPayment extends Model
{
    use HasFactory;
    use HasRestaurant;

    protected $guarded = ['id'];

    protected $casts = [
        'payment_date_time' => 'datetime',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

}
