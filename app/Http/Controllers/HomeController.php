<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Package;
use App\Models\Module;
use App\Enums\PackageType;
use Froiden\Envato\Traits\AppBoot;

class HomeController extends Controller
{

    use AppBoot;

    public function landing()
    {

        $this->showInstall();

        if (global_setting()->landing_site_type == 'custom') {
            return response(file_get_contents(global_setting()->landing_site_url));
        }

        $modules = Module::all();

        $packages = Package::with('modules')
            ->where('package_type', '!=', PackageType::DEFAULT)
            ->where('package_type', '!=', PackageType::TRIAL)
            ->where('is_private', false)
            ->get();

        $trialPackage = Package::where('package_type', PackageType::TRIAL)->first();


        return view('landing.index', compact('packages', 'modules', 'trialPackage'));
    }

    public function signup()
    {
        if (global_setting()->disable_landing_site) {
            return view('auth.restaurant_register');
        }

        return view('auth.restaurant_signup');
    }

    public function customerLogout()
    {
        session()->flush();
        return redirect('/');
    }
}
