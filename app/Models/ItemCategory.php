<?php

namespace App\Models;

use App\Traits\HasBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ItemCategory extends Model
{

    use HasFactory;
    use HasBranch;

    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->withoutGlobalScopes();
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(OrderItem::class, MenuItem::class,
            'item_category_id', // Foreign key on the environments table...
            'menu_item_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

}
