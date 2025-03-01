<?php

namespace App\Traits;

use App\Models\Restaurant;
use App\Scopes\RestaurantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRestaurant
{

    protected static function booted()
    {
        static::addGlobalScope(new RestaurantScope());
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

}
