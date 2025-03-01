<?php

namespace App\View\Components;

use App\Models\GlobalSetting;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;
use Illuminate\View\View;

class AuthLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        // SAAS
        if (module_enabled('Subdomain')) {
            $restaurant = getRestaurantBySubDomain();
            $globalSetting = $restaurant ?? GlobalSetting::first();
        } else {
            $globalSetting = global_setting();
        }

        $appTheme = $globalSetting;

        App::setLocale(session('locale') ?? $globalSetting->locale);

        return view('layouts.auth', [
            'globalSetting' => $globalSetting,
            'appTheme' => $appTheme,
        ]);
    }
}
