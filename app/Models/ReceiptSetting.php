<?php

namespace App\Models;

use App\Traits\HasRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ReceiptSetting extends Model
{
    use HasRestaurant;
    use HasFactory;
    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    protected $appends = [
        'payment_qr_code_url',
    ];

    public function paymentQrCodeUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->payment_qr_code ? asset_url_local_s3('payment_qr_code/' . $this->payment_qr_code) : '';
        });
    }

}
