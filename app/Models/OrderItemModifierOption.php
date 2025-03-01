<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemModifierOption extends Model
{
    protected $guarded = ['id'];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function modifierOption(): BelongsTo
    {
        return $this->belongsTo(ModifierOption::class, 'modifier_option_id');
    }


}
