<?php

namespace App\Http\Controllers;

use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\GlobalInvoice;
use App\Models\OfflinePlanChange;
use App\Models\GlobalSubscription;

class BillingController extends Controller
{

    public function index()
    {
        return view('billing.index');
    }

    public function offlinePlanRequests()
    {
        return view('billing.offline-request');
    }

}
