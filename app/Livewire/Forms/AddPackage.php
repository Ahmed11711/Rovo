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

class AddPackage extends Component
{
    use LivewireAlert;

    public $packageName;
    public $description;
    public $currencyID;
    public $price;
    public $annualPrice;
    public $monthlyPrice;
    public bool $isFree = false;
    public bool $monthlyStatus = false;
    public bool $annualStatus = false;
    public $sortOrder;
    public bool $isPrivate = false;
    public bool $isRecommended = false;
    public $packageType;
    public $trialDays;
    public $trialStatus;
    public $packageTypes;
    public bool $toggleSelectedModules = false;
    public $selectedModules = [];
    public $modules;
    public $currencies;
    public $currencySymbol;
    public $maxOrder;
    public $paymentKey;
    public $stripeAnnualPlanId;
    public $stripeMonthlyPlanId;
    public $razorpayAnnualPlanId;
    public $razorpayMonthlyPlanId;
    public $additionalFeatures;
    public $selectedFeatures = [];
    public $showPackageDetailsForm = true;
    public $showModulesForm = false;
    public $branchLimit;


    public function mount()
    {
        $this->maxOrder = Package::count();
        $this->sortOrder = $this->maxOrder + 1;
        $this->packageTypes = array_filter(PackageType::cases(), function ($type) {
            return !in_array($type, [PackageType::TRIAL, PackageType::DEFAULT, PackageType::FREE]);
        });
        $this->modules = Module::all();
        $this->currencies = GlobalCurrency::all();
        $this->currencyID = global_setting()->default_currency_id;
        $this->currencySymbol = $this->currencies->first()->currency_symbol ?? null;
        $this->packageType = PackageType::STANDARD->value;
        $this->paymentKey = SuperadminPaymentGateway::first();
        $this->additionalFeatures = Package::ADDITIONAL_FEATURES;
    }

    public function updatedCurrencyID()
    {
        $this->currencySymbol = GlobalCurrency::find($this->currencyID)->currency_symbol ?? null;
    }

    public function goBack()
    {
        $this->showPackageDetailsForm = true;
        $this->showModulesForm = false;
    }

    public function updatedPackageType($value)
    {
        if ($value == PackageType::LIFETIME->value) {
            $this->annualStatus = false;
            $this->monthlyStatus = false;
            $this->annualPrice = null;
            $this->monthlyPrice = null;
        }
    }

    public function updatedIsFree($value)
    {
        if ($value) {
            $this->packageType = PackageType::FREE->value;
            $this->annualStatus = false;
            $this->monthlyStatus = false;
            $this->annualPrice = null;
            $this->monthlyPrice = null;
        }
    }

    public function updatedToggleSelectedModules($value)
    {
        $this->selectedModules = $value ? $this->modules->pluck('id')->toArray() : [];
    }

    public function submitForm()
    {
        $validateRules = [
            'packageName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('packages', 'package_name'),
            ],
            'isFree' => 'required|boolean',
            'sortOrder' => 'required|integer',
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
            'description' => 'required',
            'selectedModules' => 'array|min:1',
            'branchLimit' => [
                'nullable',
                'integer',
                'min:-1',
                Rule::requiredIf(fn() => in_array('Change Branch', $this->selectedFeatures))
            ],
        ];

        if (($this->monthlyPrice == true ) && ($this->paymentKey->razorpay_status == 1)) {
            $validateRules['razorpayMonthlyPlanId'] = 'required';
        }

        if (($this->annualPrice == true ) && ($this->paymentKey->razorpay_status == 1)) {
            $validateRules['razorpayAnnualPlanId'] = 'required';
        }

        if (($this->annualPrice == true ) && ($this->paymentKey->stripe_status == 1)) {
            $validateRules['stripeAnnualPlanId'] = 'required';
        }

        if (($this->monthlyPrice == true ) && ($this->paymentKey->stripe_status == 1)) {
            $validateRules['stripeMonthlyPlanId'] = 'required';
        }

        $validateMessages = [
            'selectedModules.min' => 'Please select at least one module',
            'packageName.unique' => 'The package name has already been taken.',
            'price.required_if' => 'The price field is required.',
            'annualPrice.required_if' => 'The annual price field is required.',
            'monthlyPrice.required_if' => 'The monthly price field is required.',
            'branchLimit.required_if' => 'The branch limit field is required when Change Branch is selected.',
        ];

        $this->validate($validateRules, $validateMessages);


        Package::where('sort_order', '>=', $this->sortOrder)
            ->increment('sort_order');

        $package = new Package();
        $package->package_name = $this->packageName;
        $package->description = $this->description;
        $package->package_type = $this->packageType;
        $package->price = $this->packageType === PackageType::LIFETIME->value ? $this->price : 0;
        $package->currency_id = $this->currencyID;
        $package->annual_price = $this->annualPrice;
        $package->monthly_price = $this->monthlyPrice;
        $package->is_free = $this->isFree;
        $package->monthly_status = $this->monthlyStatus;
        $package->annual_status = $this->annualStatus;
        $package->sort_order = $this->sortOrder;
        $package->is_private = $this->isPrivate;
        $package->is_recommended = $this->isRecommended;
        $package->stripe_annual_plan_id = $this->stripeAnnualPlanId;
        $package->stripe_monthly_plan_id = $this->stripeMonthlyPlanId;
        $package->razorpay_annual_plan_id = $this->razorpayAnnualPlanId;
        $package->razorpay_monthly_plan_id = $this->razorpayMonthlyPlanId;
        $package->additional_features = json_encode($this->selectedFeatures);
        $package->branch_limit = $this->branchLimit;
        $package->save();

        $package->modules()->sync($this->selectedModules);

        $this->dispatch('hideAddPackage');

        $this->alert('success', __('messages.packageAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        return $this->redirect(route('superadmin.packages.index'), navigate: true);
    }


    public function render()
    {
        return view('livewire.forms.add-package');
    }
}
