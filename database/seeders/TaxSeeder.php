<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($restaurant): void
    {
        Tax::create([
            'tax_name' => 'SGST',
            'tax_percent' => '2.5',
            'restaurant_id' => $restaurant->id
        ]);

        Tax::create([
            'tax_name' => 'CGST',
            'tax_percent' => '2.5',
            'restaurant_id' => $restaurant->id
        ]);
    }

}
