<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Helper\Files;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SuperadminThemeSettings extends Component
{
    use LivewireAlert, WithFileUploads;

    public $settings;
    public $themeColor;
    public $themeColorRgb;
    public $photo;
    public $appName;
    public $showLogoText;
    public $upload_fav_icon_android_chrome_192;
    public $upload_fav_icon_android_chrome_512;
    public $upload_fav_icon_apple_touch_icon;
    public $upload_favicon_16;
    public $upload_favicon_32;
    public $favicon;
    public $savedImages;
    public $webmanifest;


    public function rules()
    {
        return [
        'uploadFavIconAndroidhCrome192' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        'uploadFavIconAndroidhCrome512' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        'uploadFavIconAppleTouchIcon' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        'uploadFavicon16' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        'uploadFavicon32' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        'favicon' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ];
    }

    public function mount()
    {
        $this->themeColor = $this->settings->theme_hex;
        $this->themeColorRgb = $this->settings->theme_rgb;
        $this->appName = $this->settings->name;
        $this->showLogoText = (bool)$this->settings->show_logo_text;
         $this->savedImages = [
        'upload_fav_icon_android_chrome_192' => $this->settings->upload_fav_icon_android_chrome_192,
        'upload_fav_icon_android_chrome_512' => $this->settings->upload_fav_icon_android_chrome_512,
        'upload_fav_icon_apple_touch_icon' => $this->settings->upload_fav_icon_apple_touch_icon,
        'upload_favicon_16' => $this->settings->upload_favicon_16,
        'upload_favicon_32' => $this->settings->upload_favicon_32,
        'favicon' => $this->settings->favicon,

         ];
        $this->webmanifest = $this->settings->webmanifest;

    }

    public function submitForm()
    {
        $this->validate([
            'themeColor' => 'required',
        ]);
        $this->themeColorRgb = $this->hex2rgba($this->themeColor);

        $this->settings->name = $this->appName;
        $this->settings->theme_hex = $this->themeColor;
        $this->settings->theme_rgb = $this->themeColorRgb;
        $this->settings->show_logo_text = $this->showLogoText;

        if ($this->photo) {
            $this->settings->logo = Files::uploadLocalOrS3($this->photo, dir: 'logo', width: 150, height: 150);
        }

        $favicons = [
            'upload_fav_icon_android_chrome_192' => 'android-chrome-192x192.png',
            'upload_fav_icon_android_chrome_512' => 'android-chrome-512x512.png',
            'upload_fav_icon_apple_touch_icon' => 'apple-touch-icon.png',
            'upload_favicon_16' => 'favicon-16x16.png',
            'upload_favicon_32' => 'favicon-32x32.png',
            'favicon' => 'favicon.ico',
        ];

        foreach ($favicons as $property => $filename) {
            if ($this->$property) {
                $path = $this->$property->storeAs('favicons/super-admin', $filename);
                $this->settings->$property = basename($path);
            }
        }

        if ($this->webmanifest) {
            $path = $this->webmanifest->storeAs('favicons/super-admin', 'site.webmanifest');
            $this->settings->webmanifest = basename($path); // Save the webmanifest filename in the settings
        }
        $this->settings->save();

        cache()->forget('global_setting');
        session()->forget('restaurantOrGlobalSetting');

        $this->redirect(route('superadmin.superadmin-settings.index') . '?tab=theme', navigate: true);


        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function hex2rgba($color)
    {

        list($r, $g, $b) = sscanf($color, '#%02x%02x%02x');

        return $r . ', ' . $g . ', ' . $b;
    }

    public function deleteLogo()
    {
        cache()->forget('global_setting');

        if (is_null($this->settings->logo)) {
            return;
        }

        Files::deleteFile($this->settings->logo, 'logo');

        $this->settings->forceFill(['logo' => null])->save();

        $this->redirect(route('superadmin.superadmin-settings.index') . '?tab=theme', navigate: true);
    }

    public function render()
    {
        return view('livewire.settings.superadmin-theme-settings');
    }

}
