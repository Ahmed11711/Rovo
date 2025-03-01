<?php

namespace App\Models;

use App\Traits\HasRestaurant;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasRestaurant;
    
    protected $fillable = [
        'name',
        'guard_name',
        'restaurant_id',
        'display_name'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
} 