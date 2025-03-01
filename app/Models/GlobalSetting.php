<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class GlobalSetting extends Model
{

    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'logo_url',
    ];

    protected $casts = [
        'purchased_on' => 'datetime',
        'supported_until' => 'datetime',
        'last_license_verified_at' => 'datetime',
        'last_cron_run' => 'datetime',
    ];

    public function logoUrl(): Attribute
    {
        return Attribute::get(fn(): string => $this->logo ? asset_url_local_s3('logo/' . $this->logo) : asset('img/logo.png'));
    }

    public function defaultCurrency(): BelongsTo
    {
        return $this->belongsTo(GlobalCurrency::class, 'default_currency_id');
    }
}
