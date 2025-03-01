<?php

namespace Database\Seeders;

use App\Models\PusherSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PusherSettinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = PusherSetting::count();

        if ($setting > 0) {
            $setting = new PusherSetting();
            $setting->save();
        }
    }
}
