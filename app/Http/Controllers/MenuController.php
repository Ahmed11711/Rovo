<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Menu', restaurant_modules()), 403);
        abort_if((!user_can('Show Menu')), 403);

        return view('menu.index');
    }

}
