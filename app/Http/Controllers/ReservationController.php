<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Reservation', restaurant_modules()), 403);
        abort_if((!user_can('Show Reservation')), 403);
        return view('reservations.index');
    }

}
