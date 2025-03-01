<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Menu Item', restaurant_modules()), 403);
        abort_if((!user_can('Show Menu Item')), 403);
        return view('menu_items.index');
    }

}
