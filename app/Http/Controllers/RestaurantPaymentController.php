<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantPaymentController extends Controller
{
    
    public function index()
    {
        return view('restaurant-payments.index');
    }

}
