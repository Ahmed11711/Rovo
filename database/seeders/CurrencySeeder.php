<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($restaurant): void
    {

        $currency = new Currency();
        $currency->currency_name = 'Rupee';
        $currency->currency_symbol = '₹';
        $currency->currency_code = 'INR';
        $currency->restaurant_id = $restaurant->id;
        $currency->currency_position = 'left';
        $currency->no_of_decimal = 2;
        $currency->thousand_separator = ',';
        $currency->decimal_separator = '.';
        $currency->saveQuietly();

        $currency = new Currency();
        $currency->currency_name = 'Dollars';
        $currency->currency_symbol = '$';
        $currency->currency_code = 'USD';
        $currency->restaurant_id = $restaurant->id;
        $currency->currency_position = 'left';
        $currency->no_of_decimal = 2;
        $currency->thousand_separator = ',';
        $currency->decimal_separator = '.';
        $currency->saveQuietly();

        $restaurant->currency_id = $currency->id;
        $restaurant->save();

        $currency = new Currency();
        $currency->currency_name = 'Pounds';
        $currency->currency_symbol = '£';
        $currency->currency_code = 'GBP';
        $currency->restaurant_id = $restaurant->id;
        $currency->currency_position = 'left';
        $currency->no_of_decimal = 2;
        $currency->thousand_separator = ',';
        $currency->decimal_separator = '.';
        $currency->saveQuietly();

        $currency = new Currency();
        $currency->currency_name = 'Euros';
        $currency->currency_symbol = '€';
        $currency->currency_code = 'EUR';
        $currency->restaurant_id = $restaurant->id;
        $currency->currency_position = 'left';
        $currency->no_of_decimal = 2;
        $currency->thousand_separator = ',';
        $currency->decimal_separator = '.';
        $currency->saveQuietly();
    }

}
