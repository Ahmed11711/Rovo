<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingStepController extends Controller
{

    public function index()
    {
        abort_if(!user()->hasRole('Admin_'.user()->restaurant_id), 403);
        
        return view('onboarding.index');
    }

}
