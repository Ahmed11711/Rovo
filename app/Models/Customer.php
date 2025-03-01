<?php

namespace App\Models;

use App\Traits\HasRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory;
    use Notifiable;
    use HasRestaurant;

    protected $guarded = ['id'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->orderBy('id', 'desc');
    }

}
