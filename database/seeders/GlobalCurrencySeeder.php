<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlobalCurrency;

class GlobalCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addCurrencies();
    }

    public function addCurrencies()
    {
        GlobalCurrency::firstOrCreate([
            'currency_code' => 'USD'
        ], [
            'currency_name' => 'Dollars',
            'currency_symbol' => '$',
            'currency_code' => 'USD',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'INR'
        ], [
            'currency_name' => 'Rupee',
            'currency_symbol' => '₹',
            'currency_code' => 'INR',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'GBP'
        ], [
            'currency_name' => 'Pounds',
            'currency_symbol' => '£',
            'currency_code' => 'GBP',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'EUR'
        ], [
            'currency_name' => 'Euros',
            'currency_symbol' => '€',
            'currency_code' => 'EUR',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);
    }
}
