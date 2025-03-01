<?php

namespace App\Http\Controllers;

use App\Exports\DeliveryExecutiveExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryExecutiveController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Delivery Executive', restaurant_modules()), 403);
        abort_if((!user_can('Show Delivery Executive')), 403);
        return view('delivery-executive.index');
    }

}
