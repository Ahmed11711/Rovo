<?php
namespace App\Livewire\Plan;

use App\Models\User;
use App\Helper\Files;
use App\Helper\Reply;
use Razorpay\Api\Api;
use App\Models\Module;
use App\Models\Country;
use App\Models\Package;
use Livewire\Component;
use App\Enums\PackageType;
use App\Models\Restaurant;
use Livewire\Attributes\On;
use App\Models\GlobalInvoice;
use Livewire\WithFileUploads;
use App\Models\GlobalCurrency;
use Illuminate\Support\Carbon;
use App\Scopes\RestaurantScope;
use App\Models\OfflinePlanChange;
use App\Models\RestaurantPayment;
use App\Models\GlobalSubscription;
use App\Models\OfflinePaymentMethod;
use App\Models\SuperadminPaymentGateway;
use App\Notifications\RestaurantUpdatedPlan;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Notifications\RestaurantPlanModificationRequest;

class PlanList extends Component
{

    use LivewireAlert , WithFileUploads;

    public $packages;
    public $modules;
    public $currencies;
    public $selectedCurrency;
    public bool $isAnnual = false;
    public $showPaymentMethodModal = false;
    public $paymentMethods;
    public $free = false;
    public $selectedPlan;
    public $restaurant;
    public $stripeSettings;
    public $logo;
    public $countries;
    public $methods;
    public $payFastHtml;
    public $paymentGatewayActive;
    public $offlinePaymentGateways;
    public $paymentActive;
    public $pageTitle;
    public $planId;
    public $showOnline;
    public $show = 'payment-method';
    public $offlineMethodId;
    public $offlineUploadFile;
    public $offlineDescription;

    public function mount()
    {

        $this->restaurant = Restaurant::where('id', restaurant()->id)->first();
        $this->paymentGatewayActive = false;
        $this->stripeSettings = SuperadminPaymentGateway::first();
        $this->currencies = GlobalCurrency::select('id', 'currency_name', 'currency_symbol')
        ->where('status', 'enable')
        ->get();

        if (in_array(true, [
            $this->stripeSettings->paypal_status,
            $this->stripeSettings->stripe_status,
            $this->stripeSettings->razorpay_status,
            $this->stripeSettings->paystack_status,
            $this->stripeSettings->mollie_status,
            $this->stripeSettings->payfast_status,
            $this->stripeSettings->authorize_status
        ])) {
            $this->paymentGatewayActive = true;
        }

        $this->methods = OfflinePaymentMethod::withoutGlobalScope(RestaurantScope::class)->where('status', 'active')->whereNull('restaurant_id')->get();
        $this->offlinePaymentGateways = $this->methods->count();

        $this->showOnline = $this->paymentGatewayActive;
        $this->paymentActive = $this->paymentGatewayActive || $this->offlinePaymentGateways > 0;

        $this->selectedCurrency = global_setting()->defaultCurrency->id ?? null;
        $this->modules = Module::all();

        $this->loadAvailablePackages();

    }

    public function switchPaymentMethod($method)
    {
        $this->show = $method;
    }

    // Selected Package
    public function selectedPackage($id)
    {
        $this->resetValidation();
        $this->reset(['show', 'offlineMethodId', 'offlineUploadFile', 'offlineDescription']);

        $this->selectedPlan = Package::findOrFail($id);
        $this->stripeSettings = SuperadminPaymentGateway::first();
        $this->logo = global_setting()->logo_url;
        $this->countries = Country::all();
        $this->methods = OfflinePaymentMethod::withoutGlobalScope(RestaurantScope::class)
            ->where('status', 'active')
            ->whereNull('restaurant_id')
            ->get();
        $this->free = $this->selectedPlan->payment_type == PackageType::DEFAULT || $this->selectedPlan->is_free;

        // Switching payment method based on the selected plan and modal.
        if ($this->free || !$this->paymentActive) {
            $this->showPaymentMethodModal = true;
            return;
        }

        if ($this->paymentGatewayActive) {
            $this->offlinePaymentGateways == 0 ? $this->handleOnlinePayments() : $this->showPaymentMethodModal = true;
        } else {
            $this->showPaymentMethodModal = true;
        }
    }

    // Online Payment Handling
    private function handleOnlinePayments()
    {
        $stripeActive = $this->stripeSettings->stripe_status;
        $razorpayActive = $this->stripeSettings->razorpay_status;

        if ($stripeActive && $razorpayActive) {
            $this->showPaymentMethodModal = true;
            return;
        }

        if ($stripeActive) {
            $this->initiateStripePayment();
        } elseif ($razorpayActive) {
            $this->razorpaySubscription($this->selectedPlan->id);
        } else {
            $this->showPaymentMethodModal = true;
        }
    }

    // Offline Payment Submit
    public function offlinePaymentSubmit()
    {
        $this->validate([
            'offlineMethodId' => 'required',
            'offlineUploadFile' => 'required|file',
            'offlineDescription' => 'required',
        ]);

        $checkAlreadyRequest = OfflinePlanChange::where('restaurant_id', $this->restaurant->id)
            ->where('status', 'pending')
            ->exists();

        if ($checkAlreadyRequest) {
            $this->alert('error', __('messages.alreadyRequestPending'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
            return;
        }

        $package = Package::findOrFail($this->selectedPlan->id);
        $packageType = $package->package_type == PackageType::LIFETIME ? 'lifetime' : ($this->isAnnual ? 'annual' : 'monthly');

        $offlinePlanChange = new OfflinePlanChange();
        $offlinePlanChange->package_id = $this->selectedPlan->id;
        $offlinePlanChange->package_type = $packageType;
        $offlinePlanChange->restaurant_id = $this->restaurant->id;
        $offlinePlanChange->offline_method_id = $this->offlineMethodId;
        $offlinePlanChange->description = $this->offlineDescription;
        $offlinePlanChange->amount = $this->isAnnual ? $package->annual_price : $package->monthly_price;
        $offlinePlanChange->pay_date = now()->format('Y-m-d');
        $offlinePlanChange->next_pay_date = $this->isAnnual ? now()->addYear()->format('Y-m-d') : now()->addMonth()->format('Y-m-d');

        if ($this->offlineUploadFile) {
            $offlinePlanChange->file_name = Files::uploadLocalOrS3($this->offlineUploadFile, OfflinePlanChange::FILE_PATH);
        }

        $offlinePlanChange->save();

        // Send email to superAdmin to review offline payment request
        $superAdmin = User::withoutGlobalScopes()->whereNull('branch_id')->whereNull('restaurant_id')->first();
        Notification::send($superAdmin, new RestaurantPlanModificationRequest($this->restaurant, $offlinePlanChange));

        $this->showPaymentMethodModal = false;
        $this->reset(['offlineMethodId', 'offlineUploadFile', 'offlineDescription', 'selectedPlan']);

        $this->alert('success', __('messages.requestSubmittedSuccessfully'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
        $this->redirect(route('settings.index', ['tab' => 'billing', 'offlineRequest' => 'offlineRequest']), navigate: true);
    }

    // Loading available packages based on selected currency
    public function updatedSelectedCurrency()
    {
        $this->loadAvailablePackages();
    }

    // Razorpay Subscription Initiate
    public function razorpaySubscription($planId)
    {
        $plan = Package::find($planId);
        $type = $this->isAnnual ? 'annual' : 'monthly';

        //Razorpay plan ID based on the package type and subscription type
        if ($plan->package_type == PackageType::LIFETIME) {
            $planID = $plan->razorpay_lifetime_plan_id;
        } else {
            $planID = $this->isAnnual ? $plan->razorpay_annual_plan_id : $plan->razorpay_monthly_plan_id;
        }

        $credential = SuperadminPaymentGateway::first();

        if (!$planID) {
            $this->alert('error', __('messages.noPlanIdFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
            return;
        }

        try {
            if ($credential->razorpay_type == 'test') {
            $apiKey = $credential->test_razorpay_key;
            $secretKey = $credential->test_razorpay_secret;
            } else {
            $apiKey = $credential->live_razorpay_key;
            $secretKey = $credential->live_razorpay_secret;
            }

            $api = new Api($apiKey, $secretKey);

            $subscription = $api->subscription->create(array('plan_id' => $planID, 'customer_notify' => 1, 'total_count' => 100));

            $this->dispatch('initiateRazorpay', json_encode([
                'key' => $apiKey,
                'name' => global_setting()->name,
                'description' => $plan->description,
                'image' => global_setting()->logo_url,
                'currency' => 'INR', // $plan->currency->currency_code == 'USD' ? 'US' : 'INR'
                'subscription_id' => $subscription->id,
                'notes' => [
                    'package_id' => $plan->id,
                    'package_type' => $type,
                    'restaurant_id' => $this->restaurant->id,
                ]
            ], true));

        } catch (\Exception $e) {
            $this->alert('error', __($e->getMessage()), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
        }
    }

    // Razorpay Payment Confirmation
    #[On('confirmRazorpayPayment')]
    public function confirmRazorpayPayment($payment_id, $subscription_id, $signature)
    {


        $credential = SuperadminPaymentGateway::first();

        if ($credential->razorpay_type == 'test') {
            $apiKey = $credential->test_razorpay_key;
            $secretKey = $credential->test_razorpay_secret;
        }
        else {
            $apiKey = $credential->live_razorpay_key;
            $secretKey = $credential->live_razorpay_secret;
        }

        $paymentId = $payment_id;
        $razorpaySignature = $signature;
        $subscriptionId = $subscription_id;

        try {
            $api = new Api($apiKey, $secretKey);

            $expectedSignature = hash_hmac('sha256', $paymentId . '|' . $subscriptionId, $secretKey);
        } catch (\Exception $e) {
            \session()->put('error', $e->getMessage());

            return Reply::redirect(route('billing.upgrade_plan'));
        }

        if ($expectedSignature === $razorpaySignature) {

            try {

                $payment = $api->payment->fetch($paymentId);
                $plan = Package::findOrFail($payment->notes->package_id);
                $type = $payment->notes->package_type;

                if ($payment->status == 'authorized') {
                    $payment->capture(array('amount' => $payment->amount, 'currency' => $plan->currency->currency_code));
                }

                $restaurant = $this->restaurant;
                $restaurant->package_id = $plan->id;
                $restaurant->package_type = $type;
                $restaurant->is_active = true;
                $restaurant->status = 'active';
                $restaurant->license_expire_on = null;
                $restaurant->license_updated_at = now()->format('Y-m-d');
                $restaurant->save();
                GlobalSubscription::where('restaurant_id', $restaurant->id)
                    ->where('subscription_status', 'active')
                    ->update(['subscription_status' => 'inactive']);

                // new Subscription entry
                $subscription = new GlobalSubscription();
                $subscription->restaurant_id = $restaurant->id;
                $subscription->package_type = $restaurant->package_type;
                $subscription->transaction_id = $paymentId;
                $subscription->currency_id = $plan->currency_id;
                $subscription->razorpay_id = $restaurant->package_type == 'annual' ? $plan->razorpay_annual_plan_id : $plan->razorpay_monthly_plan_id;
                $subscription->razorpay_plan = $restaurant->package_type;
                $subscription->quantity = 1;
                $subscription->package_id = $restaurant->package_id;
                $subscription->subscription_id = $subscriptionId;
                $subscription->gateway_name = 'razorpay';
                $subscription->subscription_status = 'active';
                $subscription->ends_at = $restaurant->license_expire_on ?? null;
                $subscription->subscribed_on_date = now();
                $subscription->save();

                //invoice
                if ($subscription) {
                    GlobalInvoice::create([
                        'restaurant_id' => $restaurant->id,
                        'currency_id' => $subscription->currency_id,
                        'package_id' => $subscription->package_id,
                        'global_subscription_id' => $subscription->id,
                        'transaction_id' => $subscription->transaction_id,
                        'subscription_id' =>  $subscription->subscription_id,
                        'package_type' => $subscription->package_type,
                        'plan_id' => $subscription->razorpay_id,
                        'total' => $payment->amount / 100,
                        'pay_date' => Carbon::now()->format('Y-m-d H:i:s'),
                        'next_pay_date' => $subscription->ends_at,
                        'gateway_name' => 'razorpay',
                    ]);

                    $this->showPaymentMethodModal = false;

                    // Send superadmin notification
                    $generatedBy = User::withoutGlobalScopes()->whereNull('branch_id')->whereNull('restaurant_id')->first();
                    Notification::send($generatedBy, new RestaurantUpdatedPlan($restaurant, $subscription->package_id));

                    // Send notification to restaurant admin
                    $restaurantAdmin = $restaurant->restaurantAdmin($restaurant);
                    Notification::send($restaurantAdmin, new RestaurantUpdatedPlan($restaurant, $subscription->package_id));
                    session()->forget('restaurant');
                    request()->session()->flash('flash.banner', __('messages.planUpgraded'));
                    request()->session()->flash('flash.bannerStyle', 'success');
                    request()->session()->flash('flash.link', route('settings.index', ['tab' => 'billing']));

                    $this->redirect(route('dashboard'), navigate: true);
                }
            } catch (\Exception $e) {
                \session()->put('error', $e->getMessage());

                return Reply::redirect(route('pricing.plan'));
            }
        }
    }

    // Loading Packages with currency and filters
    private function loadAvailablePackages()
    {
        if (!$this->selectedCurrency) {
            $this->packages = collect();
            return;
        }

        // Determine subscription status field based on isAnnual
        $statusField = $this->isAnnual ? 'annual_status' : 'monthly_status';

        // Build query
        $this->packages = Package::with(['currency', 'modules'])
            ->where('is_private', 0) // Non-private packages only
            ->where(function ($query) use ($statusField) {
                $query->where('package_type', 'lifetime')
                    ->orWhere('package_type', 'default') // Default packages
                    ->orWhere('is_free', true) // Include free packages
                    ->orWhere(function ($query) use ($statusField) {
                        $query->where('package_type', 'standard')
                        ->where($statusField, true); // Standard packages with the relevant status
                    });
            })
            ->where('package_type', '!=', 'trial') // Exclude trial packages
            ->where(function ($query) {
                $query->where('currency_id', $this->selectedCurrency)
                ->orWhere('package_type', 'default') // Default packages ignore currency
                ->orWhere('is_free', true); // Free packages ignore currency
            })->orderBy('sort_order')
            ->get();
    }

    // toggle Monthly and Annual
    public function toggle()
    {
        $this->isAnnual = !$this->isAnnual;
        $this->loadAvailablePackages(); // Refresh data on toggle
    }

    // initiate stripe payment
    public function initiateStripePayment()
    {

        if ($this->selectedPlan->package_type == PackageType::LIFETIME) {
            $amount = $this->selectedPlan->price;
        } else {
            $amount = $this->isAnnual ? $this->selectedPlan->annual_price : $this->selectedPlan->monthly_price;
        }

        if (!$amount) {
            $this->alert('error', __('messages.noPlanIdFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
            return;
        }

        $plan = Package::find($this->selectedPlan->id);
        $type = $this->isAnnual ? 'annual' : 'monthly';
        $currency_id = $plan->currency_id;

        $payment = RestaurantPayment::create([
            'restaurant_id' => $this->restaurant->id,
            'amount' => $amount,
            'package_id' => $plan->id,
            'package_type' => $type,
            'currency_id' => $currency_id,
        ]);

        $this->dispatch('stripePlanPaymentInitiated', payment: $payment);
    }


    public function freePlan()
    {
        $package = Package::findOrFail($this->selectedPlan->id);
        $currencyId = $package->currency_id ?: global_setting()->currency_id;
        $restaurant = $this->restaurant;
        $type = $this->isAnnual ? 'annual' : 'monthly';

        GlobalSubscription::where('restaurant_id', $restaurant->id)
            ->where('subscription_status', 'active')
            ->update(['subscription_status' => 'inactive']);

        $subscription = new GlobalSubscription();
        $subscription->restaurant_id = $restaurant->id;
        $subscription->package_id = $package->id;
        $subscription->currency_id = $currencyId;
        $subscription->package_type = $type;
        $subscription->quantity = 1;
        $subscription->gateway_name = 'offline';
        $subscription->subscription_status = 'active';
        $subscription->subscribed_on_date = now();
        $subscription->transaction_id = str(str()->random(15))->upper();
        $subscription->save();

        // create offline invoice
        $offlineInvoice = new GlobalInvoice();
        $offlineInvoice->global_subscription_id = $subscription->id;
        $offlineInvoice->restaurant_id = $restaurant->id;
        $offlineInvoice->currency_id = $currencyId;
        $offlineInvoice->package_id = $package->id;
        $offlineInvoice->package_type = $type;
        $offlineInvoice->total = 0;
        $offlineInvoice->pay_date = now()->format('Y-m-d');
        $offlineInvoice->next_pay_date = $type == 'annual' ? now()->addYear()->format('Y-m-d') : now()->addMonth()->format('Y-m-d');
        $offlineInvoice->gateway_name = 'offline';
        $offlineInvoice->transaction_id = $subscription->transaction_id;
        $offlineInvoice->save();

        // Change restaurant package
        $restaurant->package_id = $package->id;
        $restaurant->package_type = $type;
        $restaurant->status = 'active';
        $restaurant->license_expire_on = $type == 'annual' ? now()->addYear()->format('Y-m-d') : now()->addMonth()->format('Y-m-d');
        $restaurant->license_updated_at = now()->format('Y-m-d');
        $restaurant->save();

        // Send superadmin notification
        $generatedBy = User::withoutGlobalScopes()->whereNull('branch_id')->whereNull('restaurant_id')->first();
        Notification::send($generatedBy, new RestaurantUpdatedPlan($restaurant, $subscription->package_id));

        // Send notification to restaurant admin
        $restaurantAdmin = $restaurant->restaurantAdmin($restaurant);
        Notification::send($restaurantAdmin, new RestaurantUpdatedPlan($restaurant, $subscription->package_id));

        session()->forget('restaurant');


        request()->session()->flash('flash.banner', __('messages.planUpgraded'));
        request()->session()->flash('flash.bannerStyle', 'success');
        request()->session()->flash('flash.link', route('settings.index', ['tab' => 'billing']));
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function togglePaymentOptions($value)
    {
        $this->showOnline = (bool) $value;

        if ($this->showOnline) {
            $this->reset(['offlineMethodId']);
        }
    }

    // Not using this function (future use)
    // public function cancelSubscriptionRazorpay()
    // {
    //     $credential = SuperadminPaymentGateway::first();

    //     if ($credential->razorpay_mode == 'test') {
    //         $apiKey = $credential->test_razorpay_key;
    //         $secretKey = $credential->test_razorpay_secret;
    //     }
    //     else {
    //         $apiKey = $credential->live_razorpay_key;
    //         $secretKey = $credential->live_razorpay_secret;
    //     }

    //     $api = new Api($apiKey, $secretKey);

    //     // Get subscription for unsubscribe
    //     $subscriptionData = RazorpaySubscription::where('restaurant', restaurant()->id)->whereNull('ends_at')->first();

    //     if ($subscriptionData) {
    //         try {
    //             $subscription = $api->subscription->fetch($subscriptionData->subscription_id);

    //             if ($subscription->status == 'active') {

    //                 // Unsubscribe plan
    //                 $subData = $api->subscription->fetch($subscriptionData->subscription_id)->cancel(['cancel_at_cycle_end' => 0]);

    //                 // Plan will be end on this date
    //                 $subscriptionData->ends_at = \Carbon\Carbon::createFromTimestamp($subData->end_at)->format('Y-m-d');
    //                 $subscriptionData->save();
    //             }

    //         } catch (\Exception $ex) {
    //             return false;
    //         }

    //         return true;
    //     }
    // }

    public function render()
    {
        return view('livewire.plan.plan-list');
    }
}
