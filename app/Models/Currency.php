<?php

namespace App\Models;

use App\Traits\HasRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    use HasFactory, HasRestaurant;

    public $timestamps = false;

}
