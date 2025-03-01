<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SplitOrder extends Model
{
    protected $fillable = ['order_id', 'amount', 'payment_method', 'status'];

    public function items()
    {
        return $this->hasMany(SplitOrderItem::class);
    }
}
