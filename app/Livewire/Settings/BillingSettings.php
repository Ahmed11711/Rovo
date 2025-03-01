<?php

namespace App\Livewire\Settings;

use App\Models\Package;
use Livewire\Component;
use App\Enums\PackageType;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Models\GlobalInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OfflinePlanChange;
use App\Models\GlobalSubscription;
use App\Models\SuperadminPaymentGateway;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BillingSettings extends Component
{
    use WithPagination, LivewireAlert;

    public $currentTab;
    public $activeSetting;
    public $currentPackageName;
    public $currentPackageType;
    public $licenseExpireOn;
    public $currentPackageFeatures = [];
    public function mount()
    {
        $this->showTab('planDetails');
        $restaurant = Restaurant::where('id', restaurant()->id)->first();
        $this->currentPackageName = $restaurant->package->package_name;
        $this->currentPackageFeatures = json_decode($restaurant->package->additional_features, true);
        $this->currentPackageType = ucfirst($restaurant->package->package_type->value);
        $this->licenseExpireOn = ($restaurant?->license_expire_on) ? $restaurant?->license_expire_on->format('d F, Y') : __('modules.package.lifetime');
        if ($restaurant->package_type) {
            $this->currentPackageType .= ' (' . ucfirst($restaurant->package_type) . ')';
        }

    }

    public function showTab($tab)
    {
        $this->currentTab = $tab;
        $this->activeSetting = $this->currentTab;
    }

    public function downloadReceipt($id)
    {
        $invoice = GlobalInvoice::findOrFail($id);

        if (!$invoice) {

            $this->alert('error', __('messages.noInvoiceFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);

            return;
        }


        $pdf = Pdf::loadView('billing.billing-receipt', ['invoice' => $invoice]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'billing-receipt-' . uniqid() . '.pdf');
    }

    public function cancelSubscription($cancelType = false)
    {
        $subscription = GlobalSubscription::where('restaurant_id', restaurant()->id)
            ->where('subscription_status', 'active')
            ->latest()
            ->first();

        $subscriptionId = $subscription->subscription_id;
        $gatewayName = $subscription->gateway_name;

        if (!$subscriptionId) {
            $this->alert('error', __('messages.noSubscriptionFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
            return;
        }

        $paymentGateway = SuperadminPaymentGateway::first();

        if ($paymentGateway) {
            try {
                if ($gatewayName === 'stripe') {
                    $this->cancelStripeSubscription($subscriptionId, $cancelType, $paymentGateway->stripe_secret);
                } elseif ($gatewayName === 'razorpay') {
                    $this->cancelRazorpaySubscription($subscriptionId, $cancelType, $paymentGateway->razorpay_key, $paymentGateway->razorpay_secret);
                }
            } catch (\Exception $e) {
                session()->flash('error', $gatewayName . ' Error: ' . $e->getMessage());
            }
        }
    }

    private function cancelStripeSubscription($subscriptionId, $cancelType, $stripeSecret)
    {
        $stripe = new \Stripe\StripeClient($stripeSecret);
        $restaurant = Restaurant::where('id', restaurant()->id)->first();
        if ($cancelType) {
            $stripe->subscriptions->cancel($subscriptionId);
            $this->updateSubscription($restaurant);
        } else {
            $stripe->subscriptions->update($subscriptionId, [
                'cancel_at_period_end' => true,
            ]);

            $restaurant->license_expire_on = \Carbon\Carbon::createFromTimestamp($stripe->subscriptions->retrieve($subscriptionId)->current_period_end)->format('Y-m-d');
            $restaurant->save();
        }

        $this->alert('success', __('messages.subscriptionCancelled'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->js("Livewire.navigate(window.location.href)");
    }

    private function cancelRazorpaySubscription($subscriptionId, $cancelType, $razorpayKey, $razorpaySecret)
    {
        $api = new \Razorpay\Api\Api($razorpayKey, $razorpaySecret);

        $subscription = $api->subscription->fetch($subscriptionId);

        $subscription->cancel([
            'cancel_at_cycle_end' => $cancelType ? 0 : 1
        ]);

        $restaurant = Restaurant::where('id', restaurant()->id)->first();

        if ($cancelType) {
            $this->updateSubscription($restaurant);
        } else {
            $restaurant->license_expire_on = \Carbon\Carbon::createFromTimestamp($subscription->current_end)->format('Y-m-d');
            $restaurant->save();
        }

        $this->alert('success', __('messages.subscriptionCancelled'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->js("Livewire.navigate(window.location.href)");
    }

    public function updateSubscription(Restaurant $restaurant)
    {


        $package = Package::where('package_type', PackageType::DEFAULT)->first();

        $currencyId = $package->currency_id ?: global_setting()->currency_id;


        $expireDate = now()->addMonth();

        $restaurant->package_id = $package->id;
        $restaurant->package_type = 'monthly';
        $restaurant->license_expire_on = $expireDate;
        $restaurant->status = 'active';
        $restaurant->save();

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


    public function render()
    {
        $invoices = GlobalInvoice::where('restaurant_id', restaurant()->id)
            ->orderByDesc('id')
            ->paginate(10);

        $offlinePaymentRequest = OfflinePlanChange::where('restaurant_id', restaurant()->id)->paginate(10);

        return view('livewire.settings.billing-settings', [
            'offlinePaymentRequest' => $offlinePaymentRequest,
            'invoices' => $invoices
        ]);
    }
}
