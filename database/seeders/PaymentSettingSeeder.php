<?php

namespace Database\Seeders;

use App\Models\PaymentGatewayCredential;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($restaurant): void
    {
        $setting = new PaymentGatewayCredential();
        $setting->restaurant_id = $restaurant->id;
        $setting->save();
    }

}
