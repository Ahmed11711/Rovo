<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperadminPaymentGateway extends Model
{
    protected $guarded = ['id'];

    public function getRazorpayKeyAttribute()
    {
        return ($this->razorpay_type == 'test' ? $this->test_razorpay_key : $this->live_razorpay_key);
    }

    public function getRazorpaySecretAttribute()
    {
        return ($this->razorpay_type == 'test' ? $this->test_razorpay_secret : $this->live_razorpay_secret);
    }

    public function getRazorpayWebhookKeyAttribute()
    {
        return ($this->razorpay_type == 'test' ? $this->razorpay_test_webhook_key : $this->razorpay_live_webhook_key);
    }

    public function getStripeKeyAttribute()
    {
        return ($this->stripe_type == 'test' ? $this->test_stripe_key : $this->live_stripe_key);
    }

    public function getStripeSecretAttribute()
    {
        return ($this->stripe_type == 'test' ? $this->test_stripe_secret : $this->live_stripe_secret);
    }

    public function getStripeWebhookKeyAttribute()
    {
        return ($this->stripe_type == 'test' ? $this->stripe_test_webhook_key : $this->stripe_live_webhook_key);
    }

}
