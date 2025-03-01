<?php

namespace App\Observers;

use App\Models\Package;
use App\Models\Currency;
use App\Enums\PackageType;
use App\Models\Restaurant;
use App\Models\GlobalInvoice;
use App\Models\GlobalSubscription;
use App\Models\NotificationSetting;
use App\Models\PaymentGatewayCredential;
use App\Models\GlobalCurrency;
use App\Events\NewRestaurantCreatedEvent;

class RestaurantObserver
{

    public function saving(Restaurant $restaurant): void
    {
        if ($restaurant->isDirty('name')) {
            $restaurant->hash = $this->createUniqueSlug($restaurant);
        }

        if ($restaurant->isDirty(['package_id', 'package_type', 'license_expire_on'])) {
            clearRestaurantModulesCache($restaurant->id);
        }
    }

    public function created(Restaurant $restaurant)
    {
        // Add Payment Gateway Settings
        PaymentGatewayCredential::create(['restaurant_id' => $restaurant->id]);

        // Add Currencies
        $this->addCurrencies($restaurant);

        // Add Notification Settings
        $this->addNotificationSettings($restaurant);

        // Create Subscription
        $this->createSubscription($restaurant);

        // Add receipt Settings
        $restaurant->receiptSetting()->create();

        // Will be used in various module
        event(new NewRestaurantCreatedEvent($restaurant));
    }

    private function createSubscription($restaurant)
    {
        // Check if a trial package exists and trial status is active (1 or true)
        $trialPackage = Package::firstWhere('package_type', 'trial');
        $isTrialActive = $trialPackage && $trialPackage->trial_status == 1;

        // Assign either trial package or default package
        $package = $isTrialActive ? $trialPackage : Package::firstWhere('package_type', PackageType::DEFAULT);

        // Update restaurant package details
        $restaurant->update([
            'package_id' => $package->id,
            'package_type' => $isTrialActive ? 'trial' : 'monthly',
            'trial_ends_at' => $isTrialActive ? now()->addDays($trialPackage->trial_days) : null,
            'license_expire_on' => $isTrialActive ? now()->addDays($trialPackage->trial_days) : now()->addMonth(),
            'license_updated_at' => now(),
            'subscription_updated_at' => now(),
        ]);

        // Create subscription
        $subscription = GlobalSubscription::create([
            'restaurant_id' => $restaurant->id,
            'package_id' => $restaurant->package_id,
            'currency_id' => $package->currency_id,
            'package_type' => $restaurant->package_type,
            'quantity' => 1,
            'gateway_name' => 'offline',
            'subscription_status' => 'active',
            'trial_ends_at' => $isTrialActive ? $restaurant->license_expire_on : null,
            'subscribed_on_date' => $restaurant->license_updated_at,
            'ends_at' => $restaurant->license_expire_on,
            'transaction_id' => strtoupper(str()->random(15)),
        ]);

        // Create invoice
        GlobalInvoice::create([
            'restaurant_id' => $restaurant->id,
            'global_subscription_id' => $subscription->id,
            'package_id' => $subscription->package_id,
            'currency_id' => $subscription->currency_id,
            'offline_method_id' => null,
            'package_type' => $subscription->package_type,
            'total' => 0,
            'gateway_name' => 'offline',
            'status' => 'active',
            'pay_date' => $subscription->subscribed_on_date,
            'next_pay_date' => $subscription->ends_at,
            'transaction_id' => $subscription->transaction_id,
        ]);

        clearRestaurantModulesCache($restaurant->id);
    }

    public function addCurrencies($restaurant)
    {

        $globalCurrencies = GlobalCurrency::get();

        foreach ($globalCurrencies as $globalCurrency) {
            $currency = new Currency();
            $currency->currency_name = $globalCurrency->currency_name;
            $currency->currency_symbol = $globalCurrency->currency_symbol;
            $currency->currency_code = $globalCurrency->currency_code;
            $currency->restaurant_id = $restaurant->id;
            $currency->saveQuietly();
        }

        $defaultCurrency = Currency::where('currency_code', global_setting()->defaultCurrency->currency_code)->where('restaurant_id', $restaurant->id)->first();

        $restaurant->currency_id = $defaultCurrency->id;
        $restaurant->save();
    }

    public function addNotificationSettings($restaurant)
    {
        $notificationTypes = [
            [
                'type' => 'order_received',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'reservation_confirmed',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'new_reservation',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'order_bill_sent',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'staff_welcome',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ]
        ];

        NotificationSetting::insert($notificationTypes);
    }

    private function createUniqueSlug($restaurant)
    {
        $name = $restaurant->name;
        // Generate initial slug
        $slug = str()->slug($name);

        // Check if slug already exists in the database
        $count = 0;
        $originalSlug = $slug;

        while (Restaurant::where('hash', $slug)
            ->where('id', '<>', $restaurant->id)
            ->exists()
        ) {
            // Append counter to make the slug unique
            $count++;
            $slug = "{$originalSlug}-{$count}";
        }

        return $slug;
    }
}
