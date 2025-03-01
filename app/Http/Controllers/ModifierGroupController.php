<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModifierGroupController extends Controller
{
    public function index()
    {
        return view('modifier_groups.index');
    }
}
