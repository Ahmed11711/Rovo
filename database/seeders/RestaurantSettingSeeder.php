<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Country;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class RestaurantSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::where('countries_code', 'US')->first();

        $count = 1;

        if (!App::environment('codecanyon')) {
            $count = 5;
        }

        $restaurantNames = [
            'Masala Magic',
            'Spice Symphony',
            'Bombay Delight',
            'Curry Leaf',
            'Tandoor Treats',
            'The Royal Biryani',
            'Saffron House',
            'Chaat Corner',
            'Flavors of India',
            'Mughlai Masala',
            'Desi Dhaba',
            'Naan Nirvana',
            'Spice Garden',
            'Punjabi Junction',
            'The Curry Pot',
            'Rasoi Royale',
            'Biryani Bliss',
            'The Tikka Table',
            'Korma Kitchen',
            'Utsav Eatery'
        ];


        for ($i = 0; $i < $count; $i++) {
            $this->command->info('Seeding Restaurant: ' . ($i + 1));

            $companyName = $i == 0 ? 'Demo Restaurant' : $restaurantNames[$i] ?? fake()->company();

            $setting = new Restaurant();
            $setting->name = $companyName;
            $setting->address = fake()->address();
            $setting->phone_number = fake()->e164PhoneNumber;
            $setting->timezone = 'America/New_York';
            $setting->theme_hex = '#A78BFA';
            $setting->theme_rgb = '167, 139, 250';
            $setting->email = str()->slug($companyName, '.') . '@example.com';
            $setting->country_id = $country->id;
            $setting->package_id = 1; // Assuming package_id is 1 for seeding
            $setting->package_type = 'annual';
            $setting->about_us = Restaurant::ABOUT_US_DEFAULT_TEXT;
            $setting->facebook_link = 'https://www.facebook.com/';
            $setting->instagram_link = 'https://www.instagram.com/';
            $setting->twitter_link = 'https://www.twitter.com/';
            $setting->save();

            $branch = new Branch();
            $branch->restaurant_id = $setting->id;
            $branch->name = fake()->city();
            $branch->address = fake()->address();
            $branch->saveQuietly();
            $this->call(OnboardingSeeder::class, false, ['branch' => $branch]);
            $branch->generateQrCode();

            $branch = new Branch();
            $branch->restaurant_id = $setting->id;
            $branch->name = fake()->city();
            $branch->address = fake()->address();
            $branch->saveQuietly();
            $this->call(OnboardingSeeder::class, false, ['branch' => $branch]);
            $branch->generateQrCode();
        }
    }
}
