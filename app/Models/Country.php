<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    use HasFactory;

    public function flagUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return asset('flags/1x1/' . strtolower($this->countries_code) . '.svg');
        });
    }

}
