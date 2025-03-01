<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Package;
use App\Models\GlobalCurrency;
use Illuminate\Database\Seeder;
use App\Enums\PackageType;

class PackageSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Fetch the currency ID
        $currencyID = GlobalCurrency::first()->id;
        $modules = Module::all();

        // Create the Default package
        $package = new Package();
        $package->package_name = 'Default';
        $package->description = 'Its a default package and cannot be deleted';
        $package->currency_id = $currencyID;
        $package->monthly_status = 0;
        $package->annual_status = 0;
        $package->annual_price = null;
        $package->monthly_price = null;
        $package->price = 0;
        $package->is_free = 1;
        $package->billing_cycle = 12;
        $package->sort_order = 1;
        $package->is_private = 0;
        $package->is_recommended = 0;
        $package->package_type = PackageType::DEFAULT;
        $package->save();

        // Assign all modules to the default package
        $package->modules()->sync($modules->pluck('id')->toArray());

        // Create a Subscription package
        $subscriptionPackage = new Package();
        $subscriptionPackage->package_name = 'Subscription Package';
        $subscriptionPackage->description = 'This is a subscription package';
        $subscriptionPackage->currency_id = $currencyID;
        $subscriptionPackage->monthly_status = 1;
        $subscriptionPackage->annual_status = 1;
        $subscriptionPackage->annual_price = 100;
        $subscriptionPackage->monthly_price = 10;
        $subscriptionPackage->price = 0;
        $subscriptionPackage->is_free = 0;
        $subscriptionPackage->billing_cycle = 10;
        $subscriptionPackage->sort_order = 2;
        $subscriptionPackage->is_private = 0;
        $subscriptionPackage->is_recommended = 1;
        $subscriptionPackage->package_type = PackageType::STANDARD;
        $subscriptionPackage->save();

        // Assign all modules to the subscription package
        $subscriptionPackage->modules()->sync($modules->pluck('id')->toArray());

        // Create a Lifetime package
        $lifetimePackage = new Package();
        $lifetimePackage->package_name = 'Life Time';
        $lifetimePackage->description = 'This is a lifetime access package';
        $lifetimePackage->currency_id = $currencyID;
        $lifetimePackage->monthly_status = 0;
        $lifetimePackage->annual_status = 0;
        $lifetimePackage->annual_price = null;
        $lifetimePackage->monthly_price = null;
        $lifetimePackage->price = 199;
        $lifetimePackage->is_free = 0;
        $lifetimePackage->billing_cycle = 0;
        $lifetimePackage->sort_order = 3;
        $lifetimePackage->is_private = 0;
        $lifetimePackage->is_recommended = 1;
        $lifetimePackage->additional_features = json_encode(Package::ADDITIONAL_FEATURES);
        $lifetimePackage->package_type = PackageType::LIFETIME;
        $lifetimePackage->save();

        // Assign all modules to the lifetime package
        $lifetimePackage->modules()->sync($modules->pluck('id')->toArray());

        // Create a Private package
        $privatePackage = new Package();
        $privatePackage->package_name = 'Private Package';
        $privatePackage->description = 'This is a private package';
        $privatePackage->price = 0;
        $privatePackage->currency_id = $currencyID;
        $privatePackage->monthly_status = 1;
        $privatePackage->annual_status = 1;
        $privatePackage->annual_price = 50;
        $privatePackage->monthly_price = 5;
        $privatePackage->is_free = 0;
        $privatePackage->billing_cycle = 12;
        $privatePackage->sort_order = 4;
        $privatePackage->is_private = 1;
        $privatePackage->is_recommended = 0;
        $privatePackage->package_type = PackageType::STANDARD;
        $privatePackage->save();

        // Assign all modules to the private package
        $privatePackage->modules()->sync($modules->pluck('id')->toArray());


        // Create a Trial package
        $trialPackage = new Package();
        $trialPackage->package_name = 'Trial Package';
        $trialPackage->description = 'This is a trial package';
        $trialPackage->currency_id = $currencyID;
        $trialPackage->monthly_status = 0;
        $trialPackage->annual_status = 0;
        $trialPackage->annual_price = null;
        $trialPackage->monthly_price = null;
        $trialPackage->price = 0;
        $trialPackage->is_free = 1;
        $trialPackage->billing_cycle = 0;
        $trialPackage->sort_order = null;
        $trialPackage->is_private = 0;
        $trialPackage->is_recommended = 0;
        $trialPackage->package_type = PackageType::TRIAL;
        $trialPackage->additional_features = json_encode(Package::ADDITIONAL_FEATURES);
        $trialPackage->trial_days = 30;
        $trialPackage->trial_status = 1;
        $trialPackage->trial_notification_before_days = 5;
        $trialPackage->trial_message = '30 Days Free Trial';
        $trialPackage->save();

        // Assign all modules to the trial package
        $trialPackage->modules()->sync($modules->pluck('id')->toArray());
    }

}
