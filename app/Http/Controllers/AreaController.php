<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AreaController extends Controller
{
    
    public function index()
    {
        abort_if(!in_array('Area', restaurant_modules()), 403);
        abort_if((!user_can('Show Area')), 403);
        return view('areas.index');
    }

}
