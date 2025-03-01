<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperadminSettingController extends Controller
{

    public function index()
    {
        return view('superadmin-settings.index');
    }

}
