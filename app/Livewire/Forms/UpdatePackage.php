<?php

namespace App\Livewire\Forms;

use App\Models\Package;
use Livewire\Component;
use App\Enums\PackageType;
use App\Models\Restaurant;
use App\Models\GlobalInvoice;
use App\Models\GlobalSubscription;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UpdatePackage extends Component
{
    use LivewireAlert;

    public $restaurant;
    public $latestSubscription;
    public $packages;
    public $payDate;
    public $nextPayDate;
    public $licenceExpireOn;
    public $packageId;
    public $trialExpireOn;
    public $amount;
    public $allPackages;
    public $packageType;
    public $currentPackage;
    public $packageMonthlyStatus;
    public $packageAnnualStatus;
    public $monthlyPrice;
    public $billingCycle;
    public $annualPrice;
    public $selectedPackage;
    public $lifetimePrice;

    public function mount()
    {
        $this->latestSubscription = $this->restaurant;
        $this->packages = Package::all();
        $this->packageId = $this->restaurant->package_id;
        $this->initializeSelectedPackage();
    }

    public function updatedPackageId()
    {
        $this->initializeSelectedPackage();
    }

    public function updatedBillingCycle($value)
    {
        $this->updateAmountAndDates($value);
    }

    private function initializeSelectedPackage()
    {
        $this->selectedPackage = Package::findOrFail($this->packageId);
        $this->setPackageDetails();
        $this->setBillingCycleAndAmount();
    }

    private function setPackageDetails()
    {
        $this->packageType = $this->selectedPackage->package_type;
        $this->packageMonthlyStatus = $this->selectedPackage->monthly_status;
        $this->packageAnnualStatus = $this->selectedPackage->annual_status;
        $this->monthlyPrice = $this->selectedPackage->monthly_price;
        $this->annualPrice = $this->selectedPackage->annual_price;
        $this->lifetimePrice = $this->selectedPackage->price;
    }

    private function setBillingCycleAndAmount()
    {
        if ($this->selectedPackage->is_free) {
            $this->billingCycle = 'free';
            $this->amount = 0;
        } elseif ($this->selectedPackage->package_type === PackageType::LIFETIME) {
            $this->billingCycle = 'lifetime';
            $this->amount = $this->lifetimePrice;
        } else {
            $this->billingCycle = 'monthly';
            $this->amount = $this->monthlyPrice;
        }
        $this->updateAmountAndDates($this->billingCycle);
    }

    private function updateAmountAndDates($cycle)
    {
        $this->amount = $this->getAmountBasedOnBillingCycle($cycle);
        $this->setPaymentDates($cycle);
    }

    private function getAmountBasedOnBillingCycle($cycle)
    {
        return match ($cycle) {
            'monthly' => $this->monthlyPrice,
            'annual' => $this->annualPrice,
            'free' => 0,
            'lifetime' => $this->lifetimePrice,
            default => $this->monthlyPrice,
        };
    }

    private function setPaymentDates($cycle)
    {
        $this->payDate = now()->format('d F Y');
        $this->nextPayDate = match ($cycle) {
            'monthly' => now()->addMonth()->format('d F Y'),
            'annual' => now()->addYear()->format('d F Y'),
            default => null,
        };
        $this->trialExpireOn = now()->addDays($this->selectedPackage->trial_days)->format('Y-m-d');
        $this->licenceExpireOn = $this->licenceExpireOn ?? $this->nextPayDate;
    }

    public function updatePackageSubmit()
    {

        $this->validatePackageData();
        $restaurant = Restaurant::with('package')->findOrFail($this->restaurant->id);
        $package = Package::findOrFail($this->selectedPackage->id);
        $isTrial = $this->packageType === PackageType::TRIAL;
        $billingCycle = $this->billingCycle;

        try {
            // Update the restaurant with the new package details
            $restaurant->package_id = $package->id;
            $restaurant->package_type = $billingCycle;
            $restaurant->trial_ends_at = $isTrial ? \Carbon\Carbon::parse($this->trialExpireOn)->format('Y-m-d') : null;
            $restaurant->is_active = true;
            $restaurant->status = 'active';
            $currencyId = $package->currency_id ?: global_setting()->currency_id;
            $payDate = $this->payDate ? \Carbon\Carbon::parse($this->payDate) : now();

            // Calculate license expiration date based on billing cycle
            $licenceExpireOn = \Carbon\Carbon::parse($this->licenceExpireOn);
            $restaurant->license_expire_on = match ($billingCycle) {
                'monthly' => $licenceExpireOn->addMonth(),
                'annual' => $licenceExpireOn->addYear(),
                'lifetime' => null,
                default => $isTrial ? \Carbon\Carbon::parse($this->trialExpireOn) : $licenceExpireOn->addMonth(),
            };

            // Deactivate existing subscriptions
            GlobalSubscription::where('restaurant_id', $restaurant->id)
                ->where('subscription_status', 'active')
                ->update(['subscription_status' => 'inactive']);


            // Create new subscription
            $subscription = GlobalSubscription::create([
                'restaurant_id' => $restaurant->id,
                'package_id' => $package->id,
                'currency_id' => $currencyId,
                'package_type' => $this->billingCycle,
                'quantity' => 1,
                'gateway_name' => 'offline',
                'subscription_status' => 'active',
                'subscribed_on_date' => $payDate,
                'ends_at' => $restaurant->license_expire_on,
                'transaction_id' => strtoupper(str()->random(15)),
            ]);

            // Create invoice for the subscription
            GlobalInvoice::create([
                'global_subscription_id' => $subscription->id,
                'restaurant_id' => $restaurant->id,
                'currency_id' => $currencyId,
                'package_id' => $restaurant->package_id,
                'package_type' => $subscription->package_type,
                'total' => $this->amount,
                'gateway_name' => 'offline',
                'transaction_id' => $subscription->transaction_id,
                'pay_date' => $subscription->subscribed_on_date,
                'next_pay_date' => $this->nextPayDate,  
            ]);

            $restaurant->save();

            // Notify the user
            $this->dispatch('hideChangePackage');
            $this->alert('success', __('messages.packageUpdated'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close'),
            ]);

        } catch (\Throwable $th) {
            info($th);
        }

    }

    public function validatePackageData()
    {
        $rules = [
            'packageId' => 'required|exists:packages,id',
        ];

        if ($this->packageType === PackageType::TRIAL) {
            $rules['trialExpireOn'] = 'required|nullable';
        } else {
            $rules['licenceExpireOn'] = 'required|nullable';
            $rules['amount'] = 'required|nullable|numeric';
            $rules['payDate'] = 'required|nullable';
            $rules['nextPayDate'] = 'required_unless:billingCycle,lifetime|nullable';
        }

        $messages = [
            'packageId.required' => __('messages.packageRequired'),
            'packageId.exists' => __('messages.packageNotFound'),
            'licenceExpireOn.required' => __('messages.licenceExpireRequired'),
            'trialExpireOn.required' => __('messages.trialExpireOnRequired'),
            'amount.required' => __('messages.amountRequired'),
            'amount.numeric' => __('messages.amountNumeric'),
            'payDate.required' => __('messages.payDateRequired'),
            'nextPayDate.required' => __('messages.nextPayDateRequired'),
        ];

        $this->validate($rules, $messages);
    }


    public function render()
    {
        return view('livewire.forms.update-package');
    }
}
