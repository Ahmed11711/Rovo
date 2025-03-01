<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GlobalInvoice extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'pay_date' => 'datetime',
        'next_pay_date'=>'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(GlobalCurrency::class, 'currency_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function globalCurrency(): BelongsTo
    {
        return $this->belongsTo(GlobalCurrency::class, 'currency_id');
    }

    public function globalSubscription(): BelongsTo
    {
        return $this->belongsTo(GlobalSubscription::class, 'global_subscription_id');
    }
}
