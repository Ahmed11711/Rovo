<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bundle extends Model
{
    public $guarded=[];
    public function products()
    {
        return $this->belongsToMany(Menu::class, 'bundle_products')->withPivot('quantity');
    }
}
