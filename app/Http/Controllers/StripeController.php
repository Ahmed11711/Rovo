<?php

namespace App\Http\Controllers;

use Error;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\GlobalInvoice;
use App\Models\StripePayment;
use App\Models\RestaurantPayment;
use App\Models\GlobalSubscription;
use App\Events\SendNewOrderReceived;
use App\Models\Package;
use App\Models\SuperadminPaymentGateway;
use App\Notifications\RestaurantUpdatedPlan;
use App\Notifications\SendOrderBill;
use Illuminate\Support\Facades\Notification;

class StripeController extends Controller
{

    public function orderPayment()
    {
        $milestonePayment = StripePayment::findOrFail(request()->order_payment);
        $paymentGateway = $milestonePayment->order->branch->restaurant->paymentGateways;

        $stripe = new \Stripe\StripeClient($paymentGateway->stripe_secret);

        $checkoutSession = $stripe->checkout->sessions->create([
          'line_items' => [[
            'price_data' => [
              'currency' => $milestonePayment->order->branch->restaurant->currency->currency_code,
              'product_data' => [
                'name' => 'Order #' .$milestonePayment->order->order_number,
              ],
              'unit_amount' => floatval($milestonePayment->amount) * 100,
            ],
            'quantity' => 1,
          ]],
          'mode' => 'payment',
          'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}',
          'cancel_url' => module_enabled('Subdomain') ? url('/') : route('shop_restaurant', ['hash' => $milestonePayment->order->branch->restaurant->hash]),
          'client_reference_id' => $milestonePayment->id
        ]);

        $milestonePayment->stripe_session_id = $checkoutSession->id;
        $milestonePayment->save();

        header('HTTP/1.1 303 See Other');
        return redirect($checkoutSession->url);
    }

    public function success()
    {
        $payment = StripePayment::where('stripe_session_id', request()->session_id)->firstOrFail();

        $paymentGateway = $payment->order->branch->restaurant->paymentGateways;

        $stripe = new \Stripe\StripeClient($paymentGateway->stripe_secret);

        try {
            $session = $stripe->checkout->sessions->retrieve(request()->session_id);

            $payment->stripe_payment_intent = $session->payment_intent;
            $payment->payment_status = 'completed';
            $payment->payment_date = now()->toDateTimeString();
            $payment->save();

            Payment::create([
                'order_id' => $payment->order_id,
                'payment_method' => 'stripe',
                'amount' => $payment->amount,
                'transaction_id' => $session->payment_intent
            ]);

            $order = Order::find($payment->order_id);
            $order->amount_paid = $payment->amount;
            $order->status = 'paid';
            $order->save();

            $this->sendNotifications($order);

            return redirect()->route('order_success', $payment->order_id);

        } catch (Error $e) {
            http_response_code(500);
            logger(json_encode(['error' => $e->getMessage()]));
        }

    }

    public function licensePayment(Request $request)
    {
        $paymentGateway = SuperadminPaymentGateway::first();
        $restaurantPayment = RestaurantPayment::findOrFail($request->license_payment);
        $restaurant = Restaurant::find($restaurantPayment->restaurant_id);
        $stripe = new \Stripe\StripeClient($paymentGateway->stripe_secret);
        if (!$restaurant->stripe_id) {
            $customer = $stripe->customers->create([
                'name' => $restaurant->name,
                'email' => $restaurant->email,
            ]);
            $restaurant->stripe_id = $customer->id;
            $restaurant->save();
        }

        $package = Package::find($request->input('package_id'));

        if ($package->package_type->value === 'standard') {
            $planType = $request->input('package_type');
            $priceId = $planType === 'annual' ? $package->stripe_annual_plan_id : $package->stripe_monthly_plan_id;

            // Check if the price ID exists in Stripe
            if (!isset($priceId) || trim($priceId) === '') {
                return redirect()->route('dashboard')->with([
                    'flash.banner' => __('messages.invalidStripePlan'),
                    'flash.bannerStyle' => 'danger'
                ]);
            }

            $response = $stripe->prices->retrieve($priceId);

            if (empty($response)) {
                return redirect()->route('dashboard')->with([
                    'flash.banner' => __('messages.invalidStripePlan'),
                    'flash.bannerStyle' => 'danger'
                ]);
            }

            $session = $stripe->checkout->sessions->create([
                'customer' => $restaurant->stripe_id,
                'line_items' => [[
                    'price' => $priceId,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => route('stripe.license_success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('dashboard'),
                'client_reference_id' => $restaurantPayment->id,
            ]);

            $restaurantPayment->stripe_session_id = $session->id;
            $restaurantPayment->save();
            header('HTTP/1.1 303 See Other');
            return redirect($session->url);
        } else {
            // Lifetime package or other
            $checkoutSession = $stripe->checkout->sessions->create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($currency?->currency_code ?? 'usd'),
                        'product_data' => [
                            'name' => 'License Payment for ' . global_setting()->name,
                        ],
                        'unit_amount' => floatval($restaurantPayment->amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.license_success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('dashboard'),
                'client_reference_id' => $restaurantPayment->id
            ]);

            $restaurantPayment->stripe_session_id = $checkoutSession->id;
            $restaurantPayment->package_type = 'lifetime';
            $restaurantPayment->save();
            header('HTTP/1.1 303 See Other');
            return redirect($checkoutSession->url);
        }
    }

    public function licenseSuccess()
    {
        $paymentGateway = SuperadminPaymentGateway::first();
        $payment = RestaurantPayment::where('stripe_session_id', request()->session_id)->firstOrFail();
        $stripe = new \Stripe\StripeClient($paymentGateway->stripe_secret);

        try {
            $session = $stripe->checkout->sessions->retrieve(request()->session_id);

            // Retrieve the invoice and payment intent
            if ($session->invoice) {
                $invoice = $stripe->invoices->retrieve($session->invoice);
                $paymentIntent = $invoice->payment_intent;

                $lineItem = $invoice->lines->data[0];
                $planId = $lineItem->plan->id ?? null;
                $subscriptionId = $lineItem->subscription ?? null;
            } else {
                $paymentIntent = $session->payment_intent;
            }

            $payment->stripe_payment_intent = $paymentIntent;
            $payment->status = 'paid';
            $payment->payment_date_time = now()->toDateTimeString();
            $payment->save();
            $restaurant = Restaurant::find($payment->restaurant_id);
            $restaurant->package_id = $payment->package_id;
            $restaurant->package_type = $payment->package_type;
            $restaurant->is_active = true;
            $restaurant->status = 'active';
            $restaurant->license_expire_on = null;
            $restaurant->save();

            GlobalSubscription::where('restaurant_id', $restaurant->id)
                ->where('subscription_status', 'active')
                ->update(['subscription_status' => 'inactive']);

            // Create new Subscription entry
            $subscription = new GlobalSubscription();
            $subscription->transaction_id = $paymentIntent;
            $subscription->restaurant_id = $restaurant->id;
            $subscription->package_type = $restaurant->package_type;
            $subscription->currency_id = $payment->currency_id;
            $subscription->stripe_id = $restaurant->stripe_id;
            $subscription->quantity = 1;
            $subscription->package_id = $restaurant->package_id;
            $subscription->gateway_name = 'stripe';
            $subscription->subscription_status = 'active';
            $subscription->subscription_id = $subscriptionId;
            $subscription->ends_at = $restaurant->license_expire_on ?? null;
            $subscription->subscribed_on_date = now()->format('Y-m-d H:i:s');
            $subscription->save();


            // Check if the invoice already exists and update or create accordingly
            if ($subscription) {
                GlobalInvoice::updateOrCreate(
                    ['transaction_id' => $subscription->transaction_id],
                    [
                        'restaurant_id' => $restaurant->id,
                        'currency_id' => $subscription->currency_id,
                        'package_id' => $subscription->package_id,
                        'global_subscription_id' => $subscription->id,
                        'package_type' => $subscription->package_type,
                        'plan_id' => $planId,
                        'total' => $payment->amount,
                        'pay_date' => Carbon::now()->format('Y-m-d H:i:s'),
                        'next_pay_date' => $subscription->ends_at,
                        'gateway_name' => 'stripe',
                    ]
                );
            }


            // Notify superadmin
            $generatedBy = User::withoutGlobalScopes()->whereNull('branch_id')->whereNull('restaurant_id')->first();
            Notification::send($generatedBy, new RestaurantUpdatedPlan($restaurant, $subscription->package_id));

            // Notify restaurant admin
            $restaurantAdmin = $restaurant->restaurantAdmin($restaurant);
            Notification::send($restaurantAdmin, new RestaurantUpdatedPlan($restaurant, $subscription->package_id));

            session()->forget('restaurant');
            request()->session()->flash('flash.banner', __('messages.planUpgraded'));
            request()->session()->flash('flash.bannerStyle', 'success');
            request()->session()->flash('flash.link', route('settings.index', ['tab' => 'billing']));

            return redirect()->route('dashboard')->with('livewire', true);
        } catch (\Exception $e) {
            logger(['error' => $e->getMessage()]);
            return redirect()->route('dashboard')->with([
                'flash.banner' => __('messages.paymentError'),
                'flash.bannerStyle' => 'danger'
            ]);
        }
    }


    public function sendNotifications($order)
    {
        SendNewOrderReceived::dispatch($order);

        if ($order->customer_id) {
            $order->customer->notify(new SendOrderBill($order));
        }
    }

}
