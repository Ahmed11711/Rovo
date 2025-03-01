<?php

namespace Database\Seeders;

use App\Models\SuperadminPaymentGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperadminPaymentGatewaySeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateway = SuperadminPaymentGateway::count();

        if ($gateway > 0) {
            $setting = new SuperadminPaymentGateway();
            $setting->save();
        }

    }

}
