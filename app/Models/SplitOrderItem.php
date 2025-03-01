<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SplitOrderItem extends Model
{
    protected $fillable = ['split_order_id', 'order_item_id'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
