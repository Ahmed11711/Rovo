<?php

namespace App\Http\Controllers;

use App\Models\Order;

class PosController extends Controller
{

    public function index()
    {
        abort_if((!in_array('Order', restaurant_modules()) || !user_can('Create Order')), 403);
        return view('pos.index');
    }

    public function show($id)
    {
        abort_if((!in_array('Order', restaurant_modules())), 403);
        $tableOrderID = $id;
        return view('pos.show', compact('tableOrderID'));
    }

    public function order($id)
    {
        abort_if((!in_array('Order', restaurant_modules())), 403);
        $tableOrderID = $id;
        return view('pos.order', compact('tableOrderID'));
    }

    public function kot($id)
    {
        abort_if((!in_array('Order', restaurant_modules())), 403);
        $orderID = $id;
        $order = Order::findOrFail($orderID);

        $showOrderDetail = request()->get('showOrderDetail') == 'true' ? true : false;
        return view('pos.kot', compact('orderID', 'showOrderDetail'));
    }

}
