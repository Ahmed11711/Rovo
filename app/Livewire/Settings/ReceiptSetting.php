<?php

namespace App\Livewire\Settings;

use App\Helper\Files;
use Livewire\Component;
use App\Models\RestaurantTax;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\ReceiptSetting as ModelsReceiptSetting;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ReceiptSetting extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $settings;
    public bool $customerName;
    public bool $customerAddress;
    public bool $tableNumber;
    public $paymentQrCode;
    public bool $waiter;
    public bool $totalGuest;
    public bool $restaurantLogo;
    public $receiptSetting;
    public bool $restaurantTax;
    public bool $showTax;
    public bool $showPaymentQrCode;

    public function mount()
    {
        $this->receiptSetting = restaurant()->receiptSetting;
        $this->customerName = (bool)$this->receiptSetting->show_customer_name;
        $this->customerAddress = (bool)$this->receiptSetting->show_customer_address;
        $this->tableNumber = (bool)$this->receiptSetting->show_table_number;
        $this->showPaymentQrCode = (bool)$this->receiptSetting->show_payment_qr_code;
        $this->waiter = (bool)$this->receiptSetting->show_waiter;
        $this->totalGuest = (bool)$this->receiptSetting->show_total_guest;
        $this->restaurantLogo = (bool)$this->receiptSetting->show_restaurant_logo;
        $this->restaurantTax = (bool)$this->receiptSetting->show_tax;
        $this->paymentQrCode = $this->receiptSetting->payment_qr_code_url;
    }

    public function submitForm()
    {


        $data = [
        'show_customer_name' => $this->customerName,
        'show_customer_address' => $this->customerAddress,
        'show_table_number' => $this->tableNumber,
        'show_payment_qr_code' => $this->showPaymentQrCode,
        'show_waiter' => $this->waiter,
        'show_total_guest' => $this->totalGuest,
        'show_restaurant_logo' => $this->restaurantLogo,
        'show_tax' => $this->restaurantTax,
        ];

        if ($this->showPaymentQrCode && !$this->paymentQrCode) {
            $this->addError('paymentQrCode', __('messages.paymentQrCodeRequired'));
            return;
        }

        // Handle QR Code upload only if a new file is provided
        if ($this->paymentQrCode instanceof TemporaryUploadedFile) {
            $data['payment_qr_code'] = Files::uploadLocalOrS3(
            $this->paymentQrCode,
            'payment_qr_code',
            150,
            150
            );
        }

        $this->receiptSetting->update($data);

        $this->dispatch('settingsUpdated');

        $this->alert('success', __('messages.settingsUpdated'), [
        'toast' => true,
        'position' => 'top-end',
        'showCancelButton' => false,
        'cancelButtonText' => __('app.close'),
        ]);
    }

    public function render()
    {
        return view('livewire.settings.receipt-setting');
    }

}
