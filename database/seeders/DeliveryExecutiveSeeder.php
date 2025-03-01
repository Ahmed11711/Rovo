<?php

namespace Database\Seeders;

use App\Models\DeliveryExecutive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryExecutiveSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($branch): void
    {
        for ($i = 0; $i < 11; $i++) {
            $customer = new DeliveryExecutive();
            $customer->branch_id = $branch->id;
            $customer->name = fake()->name();
            $customer->phone = fake()->unique()->phoneNumber();
            $customer->save();
        }
    }

}
