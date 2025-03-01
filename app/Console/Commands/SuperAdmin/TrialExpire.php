<?php

namespace App\Console\Commands\SuperAdmin;

use App\Models\Package;
use App\Enums\PackageType;
use App\Models\Restaurant;
use App\Models\GlobalInvoice;
use Illuminate\Console\Command;
use App\Models\GlobalSubscription;
use App\Notifications\TrialLicenseExp;
use App\Notifications\TrialLicenseExpPre;

class TrialExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trial-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set trial expire status of restaurants in restaurants table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $trialPackage = Package::where('package_type', PackageType::TRIAL)->first();
        $defaultPackage = Package::where('package_type', PackageType::DEFAULT)->first();

        if ($defaultPackage->annual_status) {
            $expireDate = now()->addYear()->format('Y-m-d');
        } else {
            $expireDate = now()->addMonth()->format('Y-m-d');
        }

        $this->notifyRestaurantOnNotificationDays($trialPackage);

        // Before today is just incase cron job is missed for today
        $restaurantsNotify = Restaurant::with('package')
            ->where('status', 'active')
            ->whereNotNull('license_expire_on')
            ->whereDate('license_expire_on', '<=', now())
            ->whereHas('package', function ($query) use ($trialPackage) {
                $query->where('package_type', PackageType::TRIAL)->where('id', $trialPackage->id);
            })
            ->get();

        foreach ($restaurantsNotify as $rst) {
            $restaurantUser = Restaurant::restaurantAdmin($rst);
            $rst->package_id = $defaultPackage->id;
            $rst->package_type = 'monthly';
            $rst->license_expire_on = $expireDate;
            $rst->status = 'license_expired';
            $rst->save();

            $this->updateSubscription($rst, $defaultPackage);

            $restaurantUser->notify(new TrialLicenseExp($rst));
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
        $subscription->package_id = $package->id;
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
        $offlineInvoice->restaurant_id = $restaurant->id;
        $offlineInvoice->currency_id = $currencyId;
        $offlineInvoice->package_id = $subscription->package_id;
        $offlineInvoice->package_type = $subscription->package_type;
        $offlineInvoice->total = 0.00;
        $offlineInvoice->pay_date = now();
        $offlineInvoice->next_pay_date = $subscription->ends_at;
        $offlineInvoice->gateway_name = 'offline';
        $offlineInvoice->transaction_id = $subscription->transaction_id;
        $offlineInvoice->save();
    }

    private function notifyRestaurantOnNotificationDays($trialPackage)
    {
        if (!$trialPackage->trial_notification_before_days) {
            return;
        }

        $restaurantsOnTrial = Restaurant::with('package')
            ->where('status', 'active')
            ->whereNotNull('license_expire_on')
            ->whereDate('license_expire_on', now()->addDays($trialPackage->trial_notification_before_days))
            ->whereHas('package', function ($query) use ($trialPackage) {
                $query->where('package_type', PackageType::TRIAL)->where('id', $trialPackage->id);
            })->get();

        foreach ($restaurantsOnTrial as $rst) {
            $restaurantUser = Restaurant::restaurantAdmin($rst);
            $restaurantUser->notify(new TrialLicenseExpPre($rst));
        }
    }
}
