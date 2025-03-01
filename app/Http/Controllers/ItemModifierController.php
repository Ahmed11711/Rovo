<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemModifierController extends Controller
{
    public function index()
    {
        // abort_if(!in_array('Item Category', restaurant_modules()), 403);
        // abort_if((!user_can('Show Item Category')), 403);
        return view('item_modifiers.index');
    }
}
