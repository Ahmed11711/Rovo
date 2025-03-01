<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    public function index()
    {
        return view('packages.index');
    }

    public function create()
    {
        return view('packages.create');
    }

    public function edit(Package $package)
    {
        return view('packages.edit', compact('package'));
    }
}
