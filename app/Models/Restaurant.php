<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Cashier\Billable;

class Restaurant extends Model
{
    use HasFactory, Billable;

    protected $guarded = ['id'];

    const ABOUT_US_DEFAULT_TEXT = '<p class="text-lg text-gray-600 mb-6">
          Welcome to our restaurant, where great food and good vibes come together! We\'re a local, family-owned spot that loves bringing people together over delicious meals and unforgettable moments. Whether you\'re here for a quick bite, a family dinner, or a celebration, we\'re all about making your time with us special.
        </p>
        <p class="text-lg text-gray-600 mb-6">
          Our menu is packed with dishes made from fresh, quality ingredients because we believe food should taste as
          good as it makes you feel. From our signature dishes to seasonal specials, there\'s always something to excite
          your taste buds.
        </p>
        <p class="text-lg text-gray-600 mb-6">
          But we\'re not just about the food—we\'re about community. We love seeing familiar faces and welcoming new ones.
          Our team is a fun, friendly bunch dedicated to serving you with a smile and making sure every visit feels like
          coming home.
        </p>
        <p class="text-lg text-gray-600">
          So, come on in, grab a seat, and let us take care of the rest. We can\'t wait to share our love of food with
          you!
        </p>
        <p class="text-lg text-gray-800 font-semibold mt-6">See you soon! 🍽️✨</p>';

    protected $appends = [
        'logo_url',
    ];

    protected $casts = [
        'license_expire_on' => 'datetime',
        'trial_expire_on' => 'datetime',
        'license_updated_at' => 'datetime',
        'subscription_updated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function logoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->logo ? asset_url_local_s3('logo/' . $this->logo) : global_setting()->logoUrl;
        });
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class)->withoutGlobalScopes();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class)->withoutGlobalScopes();
    }

    public function paymentGateways(): HasOne
    {
        return $this->hasOne(PaymentGatewayCredential::class)->withoutGlobalScopes();
    }

    public function restaurantPayment(): HasMany
    {
        return $this->hasMany(RestaurantPayment::class)->where('status', 'paid  ')->orderByDesc('id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function currentInvoice(): HasOne
    {
        return $this->hasOne(GlobalInvoice::class)->latest();
    }

    public static function restaurantAdmin($restaurant)
    {
        return $restaurant->users()->orderBy('id')->first();
    }

    public function receiptSetting(): HasOne
    {
        return $this->hasOne(ReceiptSetting::class);
    }
}
