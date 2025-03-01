<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    
    public function index()
    {
        abort_if(!in_array('Table', restaurant_modules()), 403);
        abort_if((!user_can('Show Table')), 403);
        return view('table.index');
    }

}
