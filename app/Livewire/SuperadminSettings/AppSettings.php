<?php

namespace App\Livewire\SuperadminSettings;

use App\Helper\Files;
use App\Models\LanguageSetting;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GlobalCurrency;

class AppSettings extends Component
{

    use LivewireAlert, WithFileUploads;

    public $settings;
    public $themeColor;
    public $themeColorRgb;
    public $photo;
    public $appName;
    public $facebook;
    public $instagram;
    public $twitter;
    public bool $requiresApproval;
    public bool $showLogoText;
    public $defaultLanguage;
    public $languageSettings;
    public $globalCurrencies;
    public $defaultCurrency;

    public function mount()
    {

        $this->themeColor = $this->settings->theme_hex;
        $this->themeColorRgb = $this->settings->theme_rgb;
        $this->appName = $this->settings->name;
        $this->facebook = $this->settings->facebook_link;
        $this->instagram = $this->settings->instagram_link;
        $this->twitter = $this->settings->twitter_link;
        $this->showLogoText = $this->settings->show_logo_text;

        $this->requiresApproval = $this->settings->requires_approval_after_signup;
        $this->defaultLanguage = $this->settings->locale;
        $this->languageSettings = LanguageSetting::where('active', 1)->get();
        $this->globalCurrencies = GlobalCurrency::where('status', 'enable')->get();
        $this->defaultCurrency = $this->settings->default_currency_id;
    }

    /**
     * @throws \Exception
     */
    public function submitForm()
    {
        $this->validate([
            'themeColor' => 'required'
        ]);

        $this->themeColorRgb = $this->hex2rgba($this->themeColor);

        $this->settings->name = $this->appName;
        $this->settings->theme_hex = $this->themeColor;
        $this->settings->theme_rgb = $this->themeColorRgb;
        $this->settings->requires_approval_after_signup = $this->requiresApproval;
        $this->settings->locale = $this->defaultLanguage;
        $this->settings->default_currency_id = $this->defaultCurrency;
        $this->settings->show_logo_text = $this->showLogoText;
        $this->settings->save();

        if ($this->photo) {
            $this->settings->logo = Files::uploadLocalOrS3($this->photo, dir: 'logo', width: 150, height: 150);
        }

        $this->settings->save();

        cache()->forget('global_setting');
        session()->forget('restaurantOrGlobalSetting');

        $this->redirect(route('superadmin.superadmin-settings.index'), navigate: true);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function hex2rgba($color): string
    {

        list($r, $g, $b) = sscanf($color, '#%02x%02x%02x');

        return $r . ', ' . $g . ', ' . $b;
    }

    public function deleteLogo()
    {
        if (is_null($this->settings->logo)) {
            return;
        }

        Files::deleteFile($this->settings->logo, 'logo');

        $this->settings->forceFill(['logo' => null])->save();

        $this->redirect(route('superadmin.superadmin-settings.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.superadmin-settings.app-settings');
    }
}
