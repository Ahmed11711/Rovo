<?php

namespace App\Http\Controllers\SuperAdmin;

use Carbon\Carbon;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Package;
use Razorpay\Api\Errors;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\GlobalInvoice;
use App\Models\GlobalCurrency;
use App\Models\GlobalSubscription;
use Illuminate\Routing\Controller;
use App\Models\SuperadminPaymentGateway;
use App\Notifications\RestaurantUpdatedPlan;
use Illuminate\Support\Facades\Notification;
use Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException;

class RazorpayWebhookController extends Controller
{

    const SUBSCRIPTION_CHARGED = 'subscription.charged';
    const PAYMENT_FAILED = 'payment.failed';
    const SUBSCRIPTION_CANCELLED = 'subscription.cancelled';
    const PAYMENT_PAID = 'payment.paid'; // for recurring payments

    public function saveInvoices(Request $request)
    {
        if (!isset($_SERVER['HTTP_X_RAZORPAY_SIGNATURE'])) {
            echo ('Signature mismatched Razorpay webhook saas');

            return false;
        }

        $credential = SuperadminPaymentGateway::first();

        $apiKey = $credential->razorpay_key;
        $secretKey = $credential->razorpay_secret;
        $secretWebhook = $credential->razorpay_webhook_key;

        $post = file_get_contents('php://input');
        $requestData = json_decode($post, true);
        $notes = $requestData['payload']['payment']['entity']['notes'] ?? null;

        if (is_null($notes)) {
            echo ('Notes Payload not found');
            return false;
        }


        if (isset($notes['webhook_hash']) && $notes['webhook_hash'] !== global_setting()->hash) {
            echo ('Main app hash mismatched: This indicates that the webhook for another app has been called.');

            return false;
        }

        $razorpayWebhookSecret = $secretWebhook;

        try {
            $api = new Api($apiKey, $secretKey);
            // $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'], ['razorpayWebhookSecret' => $razorpayWebhookSecret]
            $api->utility->verifyWebhookSignature($post, $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'], $razorpayWebhookSecret);
        } catch (Errors\SignatureVerificationError | \Exception $e) {

            return;
        }

        return match ($requestData['event']) {
            self::SUBSCRIPTION_CHARGED => $this->paymentAuthorized($requestData),
            self::PAYMENT_FAILED => $this->paymentFailed(),
            self::SUBSCRIPTION_CANCELLED => $this->subscriptionCancelled($requestData),
            default => null,
        };
    }

    /**
     * Does nothing for the main payments flow currently
     */
    protected function paymentFailed(): bool
    {
        return false;
    }

    /**
     * Does nothing for the main payments flow currently
     * @param array $requestData Webook Data
     * @throws RelatedResourceNotFoundException
     */
    protected function subscriptionCancelled(array $requestData)
    {
        $subscriptionEndedAt = $requestData['payload']['subscription']['entity']['ended_at'];

        $razorpaySubscription = GlobalSubscription::where('gateway_name', 'razorpay')->where('subscription_status', 'active')->where('transaction_id', $requestData['payload']['subscription']['entity']['id'])->first();

        if (!is_null($razorpaySubscription)) {
            $razorpaySubscription->ends_at = Carbon::createFromTimestamp($subscriptionEndedAt)->format('Y-m-d');
            $razorpaySubscription->save();

            $razorpayInvoice = GlobalInvoice::where('gateway_name', 'razorpay')->where('transaction_id', $requestData['payload']['subscription']['entity']['id'])->first();
            $razorpayInvoice->next_pay_date = null;
            $razorpayInvoice->save();
        }

        return true;
    }

    /**
     * @param array $requestData
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    protected function paymentAuthorized(array $requestData)
    {
        //
        // Order entity should be sent as part of the webhook payload
        //

        $subscriptionID = $requestData['payload']['subscription']['entity']['id'];

        $subscription = GlobalSubscription::where('gateway_name', 'razorpay')->where('subscription_id', $subscriptionID)->first() ?? null;

        if (!$subscription) {
            return response('Webhook Handled', 200);
        }

        $packageId = $subscription->package_id;
        $restaurantID = $subscription->restaurant_id;

        $plan = Package::find($packageId);
        $restaurant = Restaurant::findOrFail($restaurantID);

        // If it is already marked as paid, ignore the event
        $razorpayPaymentId = $requestData['payload']['payment']['entity']['id'];
        $credential = SuperadminPaymentGateway::first();

        if ($credential->razorpay_type == 'test') {
            $apiKey = $credential->test_razorpay_key;
            $secretKey = $credential->test_razorpay_secret;
        } else {
            $apiKey = $credential->live_razorpay_key;
            $secretKey = $credential->live_razorpay_secret;
        }

        try {
            $api = new Api($apiKey, $secretKey);
            $payment = $api->payment->fetch($razorpayPaymentId);
        } catch (\Exception $e) {

            return;
        }
        //
        // If the payment is only authorized, we capture it
        // If the merchant has enabled auto capture
        //
        try {

            $invoiceID = $requestData['payload']['payment']['entity']['invoice_id'];
            $customerID = $requestData['payload']['subscription']['entity']['customer_id'];
            $endTimeStamp = $requestData['payload']['subscription']['entity']['current_end'];
            $currencyCode = $requestData['payload']['payment']['entity']['currency'];
            $transactionId = $requestData['payload']['payment']['entity']['id'];
            $planId = $requestData['payload']['subscription']['entity']['plan_id'];

            $packageType = $subscription->package_type;

            $endDate = \Carbon\Carbon::createFromTimestamp($endTimeStamp)->format('Y-m-d');

            $currency = GlobalCurrency::where('currency_code', $currencyCode)->first();

            if ($currency) {
                $currencyID = $currency->id;
            } else {
                $currencyID = GlobalCurrency::where('currency_code', 'USD')->first()->id;
            }

            $razorpayInvoice = GlobalInvoice::where('gateway_name', 'razorpay')->where('invoice_id', $invoiceID)->first();

            // Store invoice details
            if (!$razorpayInvoice) {
                $razorpayInvoice = new GlobalInvoice();
                $razorpayInvoice->restaurant_id = $restaurant->id;
                $razorpayInvoice->currency_id = $currencyID;
                $razorpayInvoice->subscription_id = $subscriptionID;
                $razorpayInvoice->invoice_id = $invoiceID;
                $razorpayInvoice->transaction_id = $transactionId;
                $razorpayInvoice->amount = $payment->amount / 100;
                $razorpayInvoice->total = $payment->amount / 100;
                $razorpayInvoice->plan_id = $planId;
                $razorpayInvoice->package_type = $packageType;
                $razorpayInvoice->package_id = $packageId;
                $razorpayInvoice->pay_date = now()->format('Y-m-d');
                $razorpayInvoice->next_pay_date = $endDate;
                $razorpayInvoice->currency_id = $plan->currency_id;
                $razorpayInvoice->gateway_name = 'razorpay';
                $razorpayInvoice->global_subscription_id = $subscription->id;
                $razorpayInvoice->status = 'active';
                $razorpayInvoice->save();
            }



            $subscription = GlobalSubscription::where('gateway_name', 'razorpay')->where('subscription_id', $subscriptionID)->first();
            $subscription->customer_id = $customerID;
            $subscription->save();

            // Change restaurant status active after payment
            $restaurant->status = 'active';
            $restaurant->save();

            $generatedBy = User::whereNull('company_id')->get();

            Notification::send($generatedBy, new RestaurantUpdatedPlan($restaurant, $plan->id));



            return response('Webhook Handled', 200);
        } catch (\Exception $e) {
            //
            // Capture will fail if the payment is already captured
            //
            $log = array(
                'message' => $e->getMessage(),
                'payment_id' => $razorpayPaymentId,
                'event' => $requestData['event']
            );
            error_log(json_encode($log));
        }

        // Graceful exit since payment is now processed.
        exit;
    }
}
