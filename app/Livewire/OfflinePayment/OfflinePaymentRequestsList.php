<?php

namespace App\Livewire\OfflinePayment;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;
use App\Models\GlobalInvoice;
use App\Models\OfflinePlanChange;
use App\Models\GlobalSubscription;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OfflinePaymentRequestsList extends Component
{
    use WithPagination, LivewireAlert;

    public $name;
    public $description;
    public $methodId;
    public $showViewRequestModal = false;
    public $showConfirmChangeModal = false;
    public $selectViewRequest;
    public $remark;
    public $payDate;
    public $nextPayDate;
    public $status;
    public $offlinePlanChange;

    public function ViewRequest($id)
    {
        $this->selectViewRequest = OfflinePlanChange::findOrFail($id);
        $this->showViewRequestModal = true;
    }

    // Confirm the change of plan
    public function confirmChangePlan($id, $status)
    {
        $this->offlinePlanChange = OfflinePlanChange::with('restaurant')->findOrFail($id);

        if ($this->offlinePlanChange->status !== 'pending') {
            return $this->alert('error', __('messages.invalidRequest'), ['toast' => true, 'position' => 'top-end']);
        }

        $this->status = $status;
        if ($status == 'verified') {
            $this->payDate = now();
            $this->nextPayDate = $this->offlinePlanChange->package_type == 'monthly' ? Carbon::now()->addMonth() : Carbon::now()->addYear();
        }
        $this->showConfirmChangeModal = true;
    }

    // Process plan change request (accept/reject)
    public function changePlan()
    {
        if ($this->status == 'verified') {
            $this->handleVerifiedPlan();
        } elseif ($this->status == 'rejected') {
            $this->declineRequest();
        }
    }

    // Decline the request
    public function declineRequest()
    {

        $this->validate([
            'remark' => 'required|min:10',
        ]);

        $this->offlinePlanChange->update([
            'status' => 'rejected',
            'remark' => $this->remark
        ]);

        $this->showConfirmChangeModal = false;
        $this->reset(['remark', 'offlinePlanChange', 'status']);
        $this->alert('success', __('messages.OfflinePlanChangeDeclined'), ['toast' => true, 'position' => 'top-end']);
    }

    // Handle verified plan change (subscription & invoice)
    protected function handleVerifiedPlan()
    {
        $this->validate([
            'payDate' => 'required',
            'nextPayDate' => 'required'
        ]);

        $restaurant = Restaurant::find($this->offlinePlanChange->restaurant_id);

        GlobalSubscription::where('restaurant_id', $restaurant->id)
            ->where('subscription_status', 'active')
            ->update(['subscription_status' => 'inactive']);

        $this->offlinePlanChange->update([
            'status' => 'verified',
            'pay_date' => $this->payDate,
            'next_pay_date' => $this->nextPayDate,
        ]);

        $restaurant->update([
            'package_id' => $this->offlinePlanChange->package_id,
            'package_type' => $this->offlinePlanChange->package_type,
            'is_active' => true,
            'license_expire_on' => $this->nextPayDate,
            'license_updated_at' => now(),
            'subscription_updated_at' => now(),
        ]);

        $subscription = GlobalSubscription::create([
            'restaurant_id' => $restaurant->id,
            'package_id' => $restaurant->package_id,
            'currency_id' => $restaurant->package->currency_id,
            'package_type' => $restaurant->package_type,
            'quantity' => 1,
            'gateway_name' => 'offline',
            'subscription_status' => 'active',
            'subscribed_on_date' => $restaurant->license_updated_at,
            'ends_at' => $restaurant->license_expire_on,
            'transaction_id' => strtoupper(str()->random(15)),
        ]);

        GlobalInvoice::create([
            'restaurant_id' => $this->offlinePlanChange->restaurant_id,
            'global_subscription_id' => $subscription->id,
            'package_id' => $subscription->package_id,
            'currency_id' => $subscription->currency_id,
            'offline_method_id' => $this->offlinePlanChange->offline_method_id,
            'package_type' => $subscription->package_type,
            'total' => $this->offlinePlanChange->amount,
            'gateway_name' => 'offline',
            'status' => 'active',
            'pay_date' => $subscription->subscribed_on_date,
            'next_pay_date' => $subscription->ends_at,
            'transaction_id' => $subscription->transaction_id,
        ]);


        $this->showConfirmChangeModal = false;
        $this->reset(['remark', 'payDate', 'nextPayDate', 'offlinePlanChange', 'status']);
        $this->alert('success', __('messages.offlinePaymentVerified'), ['toast' => true, 'position' => 'top-end']);
    }


    public function downloadFile($id)
    {
        $request = OfflinePlanChange::findOrFail($id);

        if (empty($request->file_name)) {
            return $this->alert('error', 'File not found.');
        }

        $filePath = asset_url_local_s3(OfflinePlanChange::FILE_PATH . '/' . $request->file_name);

        if (!file_exists($filePath)) {
            return $this->alert('error', 'File not found.');
        }

        return response()->download($filePath);
    }


    public function render()
    {
        $offlinePaymentRequest = OfflinePlanChange::paginate(10);

        return view('livewire.offline-payment.offline-payment-requests-list', compact('offlinePaymentRequest'));
    }
}
