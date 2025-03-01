<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use App\Models\GlobalCurrency;
use Illuminate\Database\Seeder;
use App\Models\StorageSetting;

class GlobalSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new GlobalSetting();
        $setting->name = 'TableTrack';
        $setting->theme_hex = '#A78BFA';
        $setting->theme_rgb = '167, 139, 250';
        $setting->hash = md5(microtime());
        $setting->installed_url = config('app.url');
        $setting->facebook_link = 'https://www.facebook.com/';
        $setting->instagram_link = 'https://www.instagram.com/';
        $setting->twitter_link = 'https://www.twitter.com/';
        $setting->default_currency_id = GlobalCurrency::first()->id;
        $setting->save();

        StorageSetting::firstOrCreate([
            'filesystem' => 'local',
            'status' => 'enabled',
        ]);
    }
}
