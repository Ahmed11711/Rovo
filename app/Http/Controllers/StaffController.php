<?php

namespace App\Http\Controllers;


class StaffController extends Controller
{

    public function index()
    {
        abort_if(!in_array('Staff', restaurant_modules()), 403);
        abort_if((!user_can('Show Staff Member')), 403);
        return view('staff.index');
    }

}
