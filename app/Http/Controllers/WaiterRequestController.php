<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaiterRequestController extends Controller
{
    public function index()
    {
        abort_if((!in_array('Waiter Request', restaurant_modules()) || !user_can('Manage Waiter Request')), 403);
        return view('waiter-request.index');
    }
}
