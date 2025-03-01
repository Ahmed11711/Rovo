<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function index()
    {
        return view('restaurants.index');
    }

    public function show($id)
    {
        return view('restaurants.show', compact('id'));
    }

}
