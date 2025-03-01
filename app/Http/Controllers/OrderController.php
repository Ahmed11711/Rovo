<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\ReceiptSetting;
use App\Models\RestaurantTax;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Order', restaurant_modules()), 403);
        abort_if((!user_can('Show Order')), 403);
        return view('order.index');
    }

    public function show($id)
    {
        return view('order.show', compact('id'));
    }

    public function printOrder($id)
    {
        $payment = Payment::where('order_id', $id)->first();
        $taxDetails = RestaurantTax::where('restaurant_id', restaurant()->id)->get();
        $order = Order::find($id);
        $receiptSettings = restaurant()->receiptSetting;
        return view('order.print', compact('order', 'receiptSettings', 'taxDetails', 'payment'));
    }

}
