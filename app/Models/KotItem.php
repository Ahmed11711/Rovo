<?php

namespace App\Models;

use App\Scopes\AvailableMenuItemScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KotItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class)->withoutGlobalScope(AvailableMenuItemScope::class);
    }

    public function menuItemVariation(): BelongsTo
    {
        return $this->belongsTo(MenuItemVariation::class);
    }

    public function modifierOptions(): BelongsToMany
    {
        return $this->belongsToMany(ModifierOption::class, 'kot_item_modifier_options', 'kot_item_id', 'modifier_option_id');
    }
}
