<?php

use App\Models\Module;
use App\Models\Package;
use App\Enums\PackageType;
use App\Models\Restaurant;
use App\Models\GlobalInvoice;
use App\Models\GlobalCurrency;
use App\Models\GlobalSubscription;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $checkExist = Package::first();

        if (!$checkExist) {
            return;
        }

        $currency = GlobalCurrency::first();
        $modules = Module::all();

        if ($modules->isEmpty() || !$currency) {
            return;
        }

        $modulesIds = $modules->pluck('id')->toArray();
        $currencyID = $currency->id;

        // Create the Default package
        $package = $this->createPackage('Default', PackageType::DEFAULT->value, $currencyID, 1);
        $package->modules()->sync($modulesIds);

        // Create the Trial package
        $trialPackage = $this->createPackage('Trial Package', PackageType::TRIAL->value, $currencyID, 0, 30);
        $trialPackage->modules()->sync($modulesIds);

        // Fetch Lifetime Package
        $LifeTimePackage = Package::first();
        $LifeTimePackage->additional_features = json_encode(Package::ADDITIONAL_FEATURES);
        $LifeTimePackage->package_type = 'lifetime';
        $LifeTimePackage->description = 'This is the Lifetime package';
        $LifeTimePackage->save();
        $LifeTimePackage->modules()->sync($modulesIds);

        // Existing code for paid restaurants
        $restaurants = Restaurant::withoutGlobalScopes()->with('restaurantPayment')->where('license_type', 'paid')->get();

        foreach ($restaurants as $restaurant) {
            $paymentDate = $restaurant->restaurantPayment->first()->payment_date_time ?? now();

            $restaurant->update([
                'package_id' => $LifeTimePackage->id,
                'package_type' => 'lifetime',
                'is_active' => true,
                'license_expire_on' => null,
                'license_updated_at' => $paymentDate,
                'subscription_updated_at' => $paymentDate,
            ]);

            GlobalSubscription::where('restaurant_id', $restaurant->id)
                ->update(['subscription_status' => 'inactive']);

            $subscription = GlobalSubscription::create([
                'restaurant_id' => $restaurant->id,
                'package_id' => $restaurant->package_id,
                'currency_id' => $LifeTimePackage->currency_id,
                'package_type' => $restaurant->package_type,
                'quantity' => 1,
                'gateway_name' => 'offline',
                'subscription_status' => 'active',
                'subscribed_on_date' => $paymentDate,
                'ends_at' => null,
                'transaction_id' => strtoupper(str()->random(15)),
            ]);

            GlobalInvoice::create([
                'restaurant_id' => $restaurant->id,
                'global_subscription_id' => $subscription->id,
                'package_id' => $subscription->package_id,
                'currency_id' => $subscription->currency_id,
                'offline_method_id' => null,
                'package_type' => $LifeTimePackage->package_type,
                'sub_total' => $LifeTimePackage->price,
                'total' => $LifeTimePackage->price,
                'status' => 'active',
                'pay_date' => $paymentDate,
                'license_expire_on' => null,
                'next_pay_date' => null,
                'transaction_id' => $subscription->transaction_id,
            ]);
        }
        // Existing code for free restaurants
        $freeRestaurants = Restaurant::withoutGlobalScopes()->where('license_type', 'free')->get();

        $defaultPackage = Package::where('package_type', PackageType::DEFAULT)->first();

        foreach ($freeRestaurants as $restaurant) {
            $paymentDate = $restaurant->created_at ?? now();

            $restaurant->update([
                'package_id' => $defaultPackage->id,
                'package_type' => 'monthly',
                'is_active' => true,
                'license_expire_on' => null,
                'license_updated_at' => $paymentDate,
                'subscription_updated_at' => $paymentDate,
            ]);

            GlobalSubscription::where('restaurant_id', $restaurant->id)
                ->update(['subscription_status' => 'inactive']);

            $subscription = GlobalSubscription::create([
                'restaurant_id' => $restaurant->id,
                'package_id' => $restaurant->package_id,
                'currency_id' => $package->currency_id,
                'package_type' => $restaurant->package_type,
                'quantity' => 1,
                'gateway_name' => 'offline',
                'subscription_status' => 'active',
                'subscribed_on_date' => $paymentDate,
                'ends_at' => null,
                'transaction_id' => strtoupper(str()->random(15)),
            ]);

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
                'pay_date' => $paymentDate,
                'next_pay_date' => null,
                'transaction_id' => $subscription->transaction_id,
            ]);
        }
    }


    /**
     * Helper method to create a package.
     */
    private function createPackage(string $name, string $type, int $currencyID, int $billingCycle, int $trialDays = null): Package
    {
        $package = new Package();
        $package->package_name = $name;
        $package->description = "This is the {$name} package";
        $package->currency_id = $currencyID;
        $package->monthly_status = 0;
        $package->annual_status = 0;
        $package->annual_price = null;
        $package->monthly_price = null;
        $package->price = 0;
        $package->is_free = 1;
        $package->billing_cycle = $billingCycle;
        $package->sort_order = 1;
        $package->is_private = 0;
        $package->is_recommended = 0;
        $package->package_type = $type;

        if ($trialDays) {
            $package->trial_days = $trialDays;
            $package->trial_status = 1;
            $package->trial_notification_before_days = 5;
            $package->trial_message = "{$trialDays} Days Free Trial";
            $package->additional_features = json_encode(Package::ADDITIONAL_FEATURES);
        }

        $package->save();
        return $package;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('lifetime_subscriptions_for_paid_restaurants');
    }
};
