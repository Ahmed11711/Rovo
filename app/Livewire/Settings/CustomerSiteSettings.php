<?php
namespace App\Livewire\Settings;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CustomerSiteSettings extends Component
{

    use LivewireAlert;

    public $settings;
    public bool $customerLoginRequired;
    public bool $allowCustomerOrders;
    public bool $allowCustomerDeliveryOrders;
    public bool $allowCustomerPickupOrders;
    public bool $isWaiterRequestEnabled;
    public bool $isWaiterRequestEnabledOnDesktop;
    public bool $isWaiterRequestEnabledOnMobile;
    public bool $isWaiterRequestEnabledOpenByQr;
    public string $defaultReservationStatus;
    public $facebook;
    public $instagram;
    public $twitter;
    public $yelp;
    public bool $tableRequired;
    public bool $allowDineIn;
    public $metaKeyword;
    public $metaDescription;

    public function mount()
    {
        $this->defaultReservationStatus = $this->settings->default_table_reservation_status;
        $this->customerLoginRequired = $this->settings->customer_login_required;
        $this->allowCustomerOrders = $this->settings->allow_customer_orders;
        $this->allowCustomerDeliveryOrders = $this->settings->allow_customer_delivery_orders;
        $this->allowCustomerPickupOrders = $this->settings->allow_customer_pickup_orders;
        $this->isWaiterRequestEnabled = $this->settings->is_waiter_request_enabled;

        $this->isWaiterRequestEnabledOnDesktop = $this->settings->is_waiter_request_enabled_on_desktop;
        $this->isWaiterRequestEnabledOnMobile = $this->settings->is_waiter_request_enabled_on_mobile;
        $this->isWaiterRequestEnabledOpenByQr = $this->settings->is_waiter_request_enabled_open_by_qr;

        $this->tableRequired = $this->settings->table_required;
        $this->allowDineIn = $this->settings->allow_dine_in_orders;
        $this->facebook = $this->settings->facebook_link;
        $this->instagram = $this->settings->instagram_link;
        $this->twitter = $this->settings->twitter_link;
        $this->yelp = $this->settings->yelp_link;
        $this->metaKeyword = $this->settings->meta_keyword;
        $this->metaDescription = $this->settings->meta_description;
    }

    public function submitForm()
    {
        $this->validate([
            'defaultReservationStatus' => 'required|in:Confirmed,Checked_In,Cancelled,No_Show,Pending',
        ]);

        if (!$this->allowDineIn && !$this->allowCustomerDeliveryOrders && !$this->allowCustomerPickupOrders) {
            $this->allowCustomerOrders = false;
        }

        $this->settings->default_table_reservation_status = $this->defaultReservationStatus;
        $this->settings->customer_login_required = $this->customerLoginRequired;
        $this->settings->allow_customer_orders = $this->allowCustomerOrders;
        $this->settings->allow_customer_delivery_orders = $this->allowCustomerDeliveryOrders;
        $this->settings->allow_customer_pickup_orders = $this->allowCustomerPickupOrders;
        $this->settings->is_waiter_request_enabled = $this->isWaiterRequestEnabled;
        $this->settings->is_waiter_request_enabled_on_desktop = $this->isWaiterRequestEnabledOnDesktop;
        $this->settings->is_waiter_request_enabled_on_mobile = $this->isWaiterRequestEnabledOnMobile;
        $this->settings->is_waiter_request_enabled_open_by_qr = $this->isWaiterRequestEnabledOpenByQr;
        $this->settings->table_required = $this->tableRequired;
        $this->settings->allow_dine_in_orders = $this->allowDineIn;
        $this->settings->facebook_link = $this->facebook;
        $this->settings->instagram_link = $this->instagram;
        $this->settings->twitter_link = $this->twitter;
        $this->settings->yelp_link = $this->yelp;
         $this->settings->meta_keyword = $this->metaKeyword;
        $this->settings->meta_description = $this->metaDescription;
        $this->settings->save();

        $this->dispatch('settingsUpdated');

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.settings.customer-site-settings');
    }

}
