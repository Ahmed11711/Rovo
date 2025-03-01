<?php

namespace App\Livewire\Forms;

use App\Models\Module;
use App\Models\Package;
use Livewire\Component;
use App\Enums\PackageType;
use App\Models\GlobalCurrency;
use Illuminate\Validation\Rule;
use App\Models\SuperadminPaymentGateway;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditPackage extends Component
{

    use LivewireAlert;

    public $package;
    public $packageName;
    public $packagePrice;
    public $description;
    public $currencyID;
    public $price;
    public bool $monthlyStatus;
    public bool $annualStatus;
    public $annualPrice;
    public $monthlyPrice;
    public $sortOrder;
    public bool $isPrivate;
    public bool $isFree;
    public bool $isRecommended;
    public $packageType;
    public $trialStatus;
    public $trialNotificationBeforeDays;
    public $trialMessage;
    public $trialDays;
    public $packageModules = [];
    public $maxOrder;
    public $packageTypes;
    public $modules;
    public $currencies;
    public $showPackageDetailsForm = true;
    public $showModulesForm = false;
    public bool $toggleSelectedModules = false;
    public $selectedModules = [];
    public $currencySymbol;
    public $additionalFeatures;
    public $selectedFeatures = [];
    public $paymentKey;
    public $stripeAnnualPlanId;
    public $stripeMonthlyPlanId;
    public $razorpayAnnualPlanId;
    public $razorpayMonthlyPlanId;
    public $stripeLifetimePlanId;
    public $razorpayLifetimePlanId;
    public $packageCurrency;
    public $branchLimit;

    public function mount()
    {
        $this->initializePackageData();
        $this->initializeFormData();
    }

    private function initializePackageData()
    {
        $this->packageName = $this->package->package_name;
        $this->packagePrice = $this->package->price;
        $this->monthlyStatus = $this->package->monthly_status;
        $this->annualStatus = $this->package->annual_status;
        $this->annualPrice = $this->package->annual_price;
        $this->monthlyPrice = $this->package->monthly_price;
        $this->price = $this->package->price;
        $this->sortOrder = $this->package->sort_order;
        $this->isPrivate = $this->package->is_private;
        $this->isFree = $this->package->is_free;
        $this->isRecommended = $this->package->is_recommended;
        $this->packageType = $this->package->package_type;
        $this->trialStatus = $this->package->trial_status;
        $this->trialNotificationBeforeDays = $this->package->trial_notification_before_days;
        $this->trialMessage = $this->package->trial_message;
        $this->trialDays = $this->package->trial_days;
        $this->packageModules = $this->package->modules->pluck('id')->toArray();
        $this->currencyID = $this->package->currency_id;
        $this->description = $this->package->description;
        $this->stripeAnnualPlanId = $this->package->stripe_annual_plan_id;
        $this->stripeMonthlyPlanId = $this->package->stripe_monthly_plan_id;
        $this->razorpayAnnualPlanId = $this->package->razorpay_annual_plan_id;
        $this->razorpayMonthlyPlanId = $this->package->razorpay_monthly_plan_id;
        // $this->stripeLifetimePlanId = $this->package->stripe_lifetime_plan_id;
        // $this->razorpayLifetimePlanId = $this->package->razorpay_lifetime_plan_id;
        $this->selectedFeatures = $this->package->additional_features ? json_decode($this->package->additional_features, true) : [];
        $this->branchLimit = $this->package->branch_limit;
    }

    private function initializeFormData()
    {
        $this->selectedModules = $this->packageModules;
        $this->currencySymbol = GlobalCurrency::find($this->currencyID)->currency_symbol ?? null;
        $this->maxOrder = Package::count();
        $this->packageTypes = array_filter(PackageType::cases(),
            fn($type) => !in_array($type, [PackageType::TRIAL, PackageType::DEFAULT, PackageType::FREE]));
        $this->modules = Module::all();
        $this->currencies = GlobalCurrency::all();
        $this->toggleSelectedModules = count($this->selectedModules) === $this->modules->count();
        $this->additionalFeatures = Package::ADDITIONAL_FEATURES;
        $this->paymentKey = SuperadminPaymentGateway::first();
    }

    public function updatedCurrencyID()
    {
        $this->currencySymbol = GlobalCurrency::find($this->currencyID)->currency_symbol ?? null;
    }

    public function updatedPackageType($value)
    {
        if ($value == PackageType::LIFETIME) {
            $this->annualStatus = false;
            $this->monthlyStatus = false;
            $this->annualPrice = null;
            $this->monthlyPrice = null;
        }
    }

    public function updatedIsFree($value)
    {
        $this->packageType = $value ? PackageType::FREE : $this->package->package_type;

        if ($value) {
            $this->annualStatus = false;
            $this->monthlyStatus = false;
            $this->annualPrice = null;
            $this->monthlyPrice = null;
        }
    }

    public function updatedToggleSelectedModules($value)
    {
        $this->selectedModules = $value ? $this->modules->pluck('id')->toArray() : [];
        $this->currencies = GlobalCurrency::get();
        $this->packageCurrency = $this->package->currency_id;
    }

    public function submitForm()
    {
        $validateRules = [
            'packageName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('packages', 'package_name')->ignore($this->package->id),
            ],
            'isFree' => 'required|boolean',
            'sortOrder' => 'required_if:packageType,!=,trial|nullable|integer',
            'isPrivate' => 'required|boolean',
            'isRecommended' => 'required|boolean',
            'packageType' => 'required_if:isFree,false',
            'currencyID' => 'required_if:isFree,false',
            'annualStatus' => 'required_if:packageType,standard|boolean',
            'monthlyStatus' => 'required_if:packageType,standard|boolean',
            'price' => 'required_if:packageType,lifetime|numeric|nullable',
            'annualPrice' => [
                'nullable',
                'numeric',
                'required_if:annualStatus,true',
            ],
            'monthlyPrice' => [
                'nullable',
                'numeric',
                'required_if:monthlyStatus,true',
            ],
            'trialStatus' => 'required_if:packageType,trial|boolean|nullable',
            'trialNotificationBeforeDays' => 'required_if:packageType,trial|integer|nullable',
            'trialMessage' => 'required_if:packageType,trial|string|nullable',
            'trialDays' => 'required_if:packageType,trial|integer|nullable',
            'description' => 'required',
            'selectedModules' => 'array|min:1',
            'branchLimit' => [
                'nullable',
                'integer',
                'min:-1',
                Rule::requiredIf(fn() => in_array('Change Branch', $this->selectedFeatures))
            ],
        ];

        if ($this->paymentKey->razorpay_status == 1) {
            $validateRules['razorpayMonthlyPlanId'] = $this->monthlyStatus ? 'required' : 'nullable';
            $validateRules['razorpayAnnualPlanId'] = $this->annualStatus ? 'required' : 'nullable';
        }

        if ($this->paymentKey->stripe_status == 1) {
            $validateRules['stripeMonthlyPlanId'] = $this->monthlyStatus ? 'required' : 'nullable';
            $validateRules['stripeAnnualPlanId'] = $this->annualStatus ? 'required' : 'nullable';
        }

        $validateMessages = [
            'packageName.unique' => 'The package name has already been taken.',
            'price.required_if' => 'The price field is required.',
            'annualPrice.required_if' => 'The annual price field is required.',
            'monthlyPrice.required_if' => 'The monthly price field is required.',
            'trialStatus.required_if' => 'The trial status field is required.',
            'trialNotificationBeforeDays.required_if' => 'The trial notification before days field is required.',
            'trialMessage.required_if' => 'The trial message field is required.',
            'trialDays.required_if' => 'The trial days field is required.',
            'selectedModules.min' => 'Please select at least one module',
            'branchLimit.required_if' => 'The branch limit field is required when Change Branch is selected.',
        ];

        $this->validate($validateRules, $validateMessages);

        if ($this->package->sort_order != $this->sortOrder) {
            Package::where('sort_order', '>=', $this->sortOrder)
            ->where('id', '!=', $this->package->id)
            ->increment('sort_order');
        }

        $this->package->update([
            'package_name' => $this->packageName,
            'description' => $this->description,
            'package_type' => $this->packageType,
            'price' => $this->packageType === PackageType::LIFETIME ? $this->price : 0,
            'currency_id' => $this->currencyID,
            'annual_price' => $this->annualPrice ?: null,
            'monthly_price' => $this->monthlyPrice ?: null,
            'is_free' => $this->isFree,
            'monthly_status' => $this->monthlyStatus,
            'annual_status' => $this->annualStatus,
            'sort_order' => $this->sortOrder,
            'is_private' => $this->isPrivate,
            'is_recommended' => $this->isRecommended,
            'trial_status' => $this->trialStatus,
            'trial_notification_before_days' => $this->trialNotificationBeforeDays,
            'trial_message' => $this->trialMessage,
            'trial_days' => $this->trialDays,
            'stripe_annual_plan_id' => $this->stripeAnnualPlanId,
            'stripe_monthly_plan_id' => $this->stripeMonthlyPlanId,
            'razorpay_annual_plan_id' => $this->razorpayAnnualPlanId,
            'razorpay_monthly_plan_id' => $this->razorpayMonthlyPlanId,
            'stripe_lifetime_plan_id' => $this->packageType === PackageType::LIFETIME ? $this->stripeLifetimePlanId : null,
            'razorpay_lifetime_plan_id' => $this->packageType === PackageType::LIFETIME ? $this->razorpayLifetimePlanId : null,
            'additional_features' => json_encode($this->selectedFeatures),
            'branch_limit' => $this->branchLimit,
        ]);

        $this->package->modules()->sync($this->selectedModules);

        $this->package->restaurants->each(function ($restaurant) {
            clearRestaurantModulesCache($restaurant->id);
        });


        $this->dispatch('hideEditPackage');

        $this->reset('package');

        $this->alert('success', __('messages.packageUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        return $this->redirect(route('superadmin.packages.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.forms.edit-package');
    }

}
