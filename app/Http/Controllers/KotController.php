<?php

namespace App\Http\Controllers;

use App\Models\Kot;
use App\Models\Order;
use Illuminate\Http\Request;

class KotController extends Controller
{

    public function index()
    {
        abort_if(!in_array('KOT', restaurant_modules()), 403);
        abort_if((!user_can('Manage KOT')), 403);
        return view('kot.index');
    }

    public function printKot($id)
    {
        $kot = Kot::with('items', 'order', 'table')->find($id);
        return view('pos.printKot', compact('kot'));
    }

}
