<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModifierOption extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function modifierGroup(): BelongsTo
    {
        return $this->belongsTo(ModifierGroup::class, 'modifier_group_id');
    }

    public function orderItemModifierOptions() : HasMany
    {
        return $this->hasMany(OrderItemModifierOption::class , 'modifier_option_id');
    }

    public function kotItemModiferOptions(): HasMany
    {
        return $this->hasMany(KotItemModifierOption::class, 'modifier_option_id');
    }
}
