<?php

namespace App\Models;

use App\Traits\HasRestaurant;
use App\Scopes\RestaurantScope;
use Illuminate\Database\Eloquent\Model;

class OfflinePlanChange extends Model
{

    use HasRestaurant;

    const FILE_PATH = 'offline-invoice';

    protected $guarded = ['id'];
    
    protected $dates = [
        'pay_date',
        'next_pay_date'
    ];

    protected $casts = [
        'pay_date' => 'datetime',
        'next_pay_date' => 'datetime',
    ];

    protected $appends = ['file'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function offlineMethod()
    {
        return $this->belongsTo(OfflinePaymentMethod::class, 'offline_method_id')->withoutGlobalScope(restaurantScope::class);

    }

    public function getFileAttribute()
    {
        return ($this->file_name) ? asset_url_local_s3(OfflinePlanChange::FILE_PATH . '/' . $this->file_name) : asset('img/default-profile-3.png');
    }
}
