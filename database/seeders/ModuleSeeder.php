<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            ['name' => 'Menu'],
            ['name' => 'Menu Item'],
            ['name' => 'Item Category'],
            ['name' => 'Area'],
            ['name' => 'Table'],
            ['name' => 'Reservation'],
            ['name' => 'KOT'],
            ['name' => 'Order'],
            ['name' => 'Customer'],
            ['name' => 'Staff'],
            ['name' => 'Payment'],
            ['name' => 'Report'],
            ['name' => 'Settings'],
            ['name' => 'Delivery Executive'],
            ['name' => 'Waiter Request'],
        ];

        Module::insert($modules);
    }

}
