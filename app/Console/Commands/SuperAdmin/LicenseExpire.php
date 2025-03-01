<?php

namespace App\Console\Commands\SuperAdmin;

use App\Models\Package;
use App\Enums\PackageType;
use App\Models\Restaurant;
use App\Models\GlobalInvoice;
use Illuminate\Console\Command;
use App\Models\GlobalSubscription;
use App\Notifications\SubscriptionExpire;

class LicenseExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:license-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set license expire status of restaurants in restaurants table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $restaurants = Restaurant::with('package')
            ->where('status', 'active')
            ->whereNotNull('license_expire_on')
            ->where('license_expire_on', '<', now())
            ->whereHas('package', function ($query) {
                $query->where('package_type', '!=', PackageType::DEFAULT)->where('is_free', 0);
            })->get();

        $packages = Package::all();

        // info('restaurants' . $restaurants->count());

        $defaultPackage = $packages->firstWhere('package_type', PackageType::DEFAULT);

        $otherPackages = $packages->whereNotIn('package_type', [PackageType::DEFAULT, PackageType::LIFETIME]);

        // Set default package for license expired restaurants.
        foreach ($restaurants as $restaurant) {
            $latestInvoice = GlobalInvoice::where('restaurant_id', $restaurant->id)
                ->whereNotNull('pay_date')
                ->latest()
                ->first();

            if (!($latestInvoice && $latestInvoice->next_pay_date > now())) {
                $restaurant->package_id = $defaultPackage->id;
                $restaurant->package_type = 'monthly';
                $restaurant->license_expire_on = now()->addMonth();
                $restaurant->status = 'license_expired';
                $restaurant->save();

                $this->updateSubscription($restaurant, $defaultPackage);

                $restaurantUser = Restaurant::restaurantAdmin($restaurant);
                // info('expire for: ' . $restaurant->name);
                $restaurantUser->notify(new SubscriptionExpire($restaurant));
            }
        }

        // Sent notification to restaurants before license expire.
        foreach ($otherPackages as $package) {
            if (!is_null($package->trial_notification_before_days)) {
                $restaurantsNotify = Restaurant::with('package')
                    ->where('status', 'active')
                    ->whereNotNull('license_expire_on')
                    ->whereDate('license_expire_on', now()->addDays($package->trial_notification_before_days))
                    ->whereHas('package', function ($query) use ($package) {
                        $query->where('package_type', '!=', PackageType::DEFAULT)->where('is_free', 0)->where('id', $package->id);
                    })->get();

                foreach ($restaurantsNotify as $rst) {
                    $restaurantUser = Restaurant::restaurantAdmin($rst);
                    // $restaurantUser->notify(new LicenseExpirePre($rst));
                }
            }
        }
    }

    public function updateSubscription(Restaurant $restaurant, Package $package)
    {
        $currencyId = $package->currency_id ?: global_setting()->currency_id;

        GlobalSubscription::where('restaurant_id', $restaurant->id)
            ->where('subscription_status', 'active')
            ->update(['subscription_status' => 'inactive']);

        $subscription = new GlobalSubscription();
        $subscription->restaurant_id = $restaurant->id;
        $subscription->package_id = $restaurant->package_id;
        $subscription->currency_id = $currencyId;
        $subscription->package_type = $restaurant->package_type;
        $subscription->quantity = 1;
        $subscription->gateway_name = 'offline';
        $subscription->subscription_status = 'active';
        $subscription->subscribed_on_date = now();
        $subscription->ends_at = $restaurant->license_expire_on;
        $subscription->transaction_id = str(str()->random(15))->upper();
        $subscription->save();

        $offlineInvoice = new GlobalInvoice();
        $offlineInvoice->global_subscription_id = $subscription->id;
        $offlineInvoice->restaurant_id = $subscription->restaurant_id;
        $offlineInvoice->currency_id = $subscription->currency_id;
        $offlineInvoice->package_id = $subscription->package_id;
        $offlineInvoice->package_type = $subscription->package_type;
        $offlineInvoice->total = 0.00;
        $offlineInvoice->pay_date = now();
        $offlineInvoice->next_pay_date = $subscription->ends_at;
        $offlineInvoice->gateway_name = 'offline';
        $offlineInvoice->transaction_id = $subscription->transaction_id;
        $offlineInvoice->save();
    }
}
