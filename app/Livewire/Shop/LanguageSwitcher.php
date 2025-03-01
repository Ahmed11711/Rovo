<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\LanguageSetting;

class LanguageSwitcher extends Component
{

    public function setLanguage($locale)
    {
        session(['locale' => $locale]);
        $language = LanguageSetting::where('language_code', $locale)->first();
        $isRtl = ($language->is_rtl == 1);
        session(['isRtl' => $isRtl]);

        $this->js('window.location.reload()');

    }

    public function render()
    {
        $locale = session('locale') ?? global_setting()->locale;

        $activeLanguage = LanguageSetting::where('language_code', $locale)->first();

        return view('livewire.shop.language-switcher', [
            'activeLanguage' => $activeLanguage,
        ]);
    }

}
