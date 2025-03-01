<?php

namespace App\Http\Controllers;

class CustomerController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Customer', restaurant_modules()), 403);
        abort_if((!user_can('Show Customer')), 403);
        return view('customers.index');
    }


}
