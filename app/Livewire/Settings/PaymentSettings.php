<?php

namespace App\Livewire\Settings;

use App\Models\PaymentGatewayCredential;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Helper\Files;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use PhpParser\Node\Expr\Cast\Bool_;

class PaymentSettings extends Component
{

    use LivewireAlert, WithFileUploads;

    public $razorpaySecret;
    public $razorpayKey;
    public $razorpayStatus;
    public $isRazorpayEnabled;
    public $isStripeEnabled;
    public $offlinePaymentMethod;
    public $paymentGateway;
    public $stripeSecret;
    public $activePaymentSetting = 'razorpay';
    public $stripeKey;
    public bool $stripeStatus;
    public bool $enableForDineIn;
    public bool $enableForDelivery;
    public bool $enableForPickup;
    public $enableCashPayment = false;
    public $enableQrPayment = false;
    public $paymentDetails;
    public $qrCodeImage;
    public $isofflinepaymentEnabled;
    public bool $enablePayViaCash;
    public bool $enableOfflinePayment;

    public function mount()
    {
        $this->paymentGateway = PaymentGatewayCredential::first();
        $this->setCredentials();
    }

    public function activeSetting($tab)
    {
        $this->activePaymentSetting = $tab;
        $this->setCredentials();
    }

    private function setCredentials()
    {
        $this->razorpayKey = $this->paymentGateway->razorpay_key;
        $this->razorpaySecret = $this->paymentGateway->razorpay_secret;
        $this->razorpayStatus = (bool)$this->paymentGateway->razorpay_status;

        $this->stripeKey = $this->paymentGateway->stripe_key;
        $this->stripeSecret = $this->paymentGateway->stripe_secret;
        $this->stripeStatus = (bool)$this->paymentGateway->stripe_status;

        $this->isRazorpayEnabled = $this->paymentGateway->razorpay_status;
        $this->isStripeEnabled = $this->paymentGateway->stripe_status;

        $this->enableForDineIn = $this->paymentGateway->is_dine_in_payment_enabled;
        $this->enableForDelivery = $this->paymentGateway->is_delivery_payment_enabled;
        $this->enableForPickup = $this->paymentGateway->is_pickup_payment_enabled;

        $this->enableOfflinePayment = (bool)$this->paymentGateway->is_offline_payment_enabled;
        $this->enableQrPayment = (bool)$this->paymentGateway->is_qr_payment_enabled;
        $this->paymentDetails = $this->paymentGateway->offline_payment_detail;
        $this->qrCodeImage = $this->paymentGateway->qr_code_image_url;
        $this->enablePayViaCash = (bool)$this->paymentGateway->is_cash_payment_enabled;
    }

    public function submitFormServiceSpecific()
    {
        $this->paymentGateway->update([
            'is_dine_in_payment_enabled' => $this->enableForDineIn,
            'is_delivery_payment_enabled' => $this->enableForDelivery,
            'is_pickup_payment_enabled' => $this->enableForPickup,
        ]);
        $this->updatePaymentStatus();
        $this->alertSuccess();
    }

    public function submitFormRazorpay()
    {
        $this->validate([
            'razorpaySecret' => 'required_if:razorpayStatus,true',
            'razorpayKey' => 'required_if:razorpayStatus,true',
        ]);

        if ($this->saveRazorpaySettings() === 0) {
            $this->updatePaymentStatus();
            $this->alertSuccess();
        }
    }

    public function submitFormStripe()
    {
        $this->validate([
            'stripeSecret' => 'required_if:stripeStatus,true',
            'stripeKey' => 'required_if:stripeStatus,true',
        ]);

        if ($this->saveStripeSettings() === 0) {
            $this->updatePaymentStatus();
            $this->alertSuccess();
        }
    }

    public function submitFormOffline()
    {
        $rules = [
            'enableOfflinePayment' => 'required|boolean',
            'enableQrPayment' => 'required|boolean',
            'enablePayViaCash' => 'required|boolean'
        ];

        if ($this->enableOfflinePayment) {
            $rules['paymentDetails'] = 'required|string|max:1000';
        }

        if ($this->enableQrPayment && !$this->paymentGateway->qr_code_image) {
            $rules['qrCodeImage'] = 'required|image|max:1024';
        }

        $this->validate($rules);

        // Upload QR code image if enabled and valid
        if ($this->enableQrPayment && is_object($this->qrCodeImage) && $this->qrCodeImage->isValid()) {
            $this->qrCodeImage = Files::uploadLocalOrS3($this->qrCodeImage, PaymentGatewayCredential::QR_CODE_FOLDER, width: 150);
        } else {
            $this->qrCodeImage = $this->paymentGateway->qr_code_image;
        }


        $updateData = [
            'is_offline_payment_enabled' => $this->enableOfflinePayment,
            'offline_payment_detail' => $this->enableOfflinePayment ? $this->paymentDetails : $this->paymentDetails,
            'is_qr_payment_enabled' => $this->enableQrPayment,
            'qr_code_image' => $this->qrCodeImage,
            'is_cash_payment_enabled' => $this->enablePayViaCash,

        ];

        $this->paymentGateway->update($updateData);

        $this->updatePaymentStatus();
        $this->alertSuccess();
    }

    private function saveRazorpaySettings()
    {
        if (!$this->razorpayStatus) {
            $this->paymentGateway->update([
                'razorpay_status' => $this->razorpayStatus,
            ]);
            return 0;
        }

        try {
            $response = Http::withBasicAuth($this->razorpayKey, $this->razorpaySecret)
                ->get('https://api.razorpay.com/v1/contacts');

            if ($response->successful()) {
                $this->paymentGateway->update([
                    'razorpay_key' => $this->razorpayKey,
                    'razorpay_secret' => $this->razorpaySecret,
                    'razorpay_status' => $this->razorpayStatus,
                ]);
                return 0;
            }

            $this->addError('razorpayKey', 'Invalid Razorpay key or secret.');
        } catch (\Exception $e) {
            $this->addError('razorpayKey', 'Error: ' . $e->getMessage());
        }

        return 1;
    }

    private function saveStripeSettings()
    {

        if (!$this->stripeStatus) {
            $this->paymentGateway->update([
                'stripe_status' => $this->stripeStatus,
            ]);
            return 0;
        }

        try {
            $response = Http::withToken($this->stripeSecret)
                ->get('https://api.stripe.com/v1/customers');

            if ($response->successful()) {
                $this->paymentGateway->update([
                    'stripe_key' => $this->stripeKey,
                    'stripe_secret' => $this->stripeSecret,
                    'stripe_status' => $this->stripeStatus,
                ]);
                return 0;
            }

            $this->addError('stripeKey', 'Invalid Stripe key or secret.');
        } catch (\Exception $e) {
            $this->addError('stripeKey', 'Error: ' . $e->getMessage());
        }

        return 1;
    }

    public function updatePaymentStatus()
    {
        $this->setCredentials();
        $this->dispatch('settingsUpdated');
        session()->forget('paymentGateway');
    }

    public function alertSuccess()
    {
        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close'),
        ]);
    }

    public function render()
    {
        return view('livewire.settings.payment-settings');
    }
}
