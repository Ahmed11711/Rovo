<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_modules');
    }

}
