<?php

namespace App\Http\Controllers\NewPackage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class newPackageController extends Controller
{
    public function index()
    {
       return view('bundle.index');

    }
}
