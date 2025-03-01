<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantSettingController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Settings', restaurant_modules()), 403);
        abort_if((!user_can('Manage Settings')), 403);

        return view('settings.index');
    }

}
