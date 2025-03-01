<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\RestaurantPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(CountrySeeder::class);
        $this->call(GlobalCurrencySeeder::class);
        $this->call(GlobalSettingSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(SuperadminSeeder::class);

        $this->call(PermissionSeeder::class);
        $this->call(LanguageSettingSeeder::class);
        $this->call(RestaurantSettingSeeder::class);
        $this->call(EmailSettingSeeder::class);
        $this->call(SuperadminPaymentGatewaySeeder::class);
        $this->call(PusherSettinSeeder::class);

        $restaurants = Restaurant::with('branches')->get();

        foreach ($restaurants as $restaurant) {
            $this->command->info('Seeding restaurant: ' . ($restaurant->id));

            $branch = $restaurant->branches->first();

            $this->call(PaymentSettingSeeder::class, false, ['restaurant' => $restaurant]);
            $this->call(TaxSeeder::class, false, ['restaurant' => $restaurant]);
            $this->call(RoleSeeder::class, false, ['restaurant' => $restaurant]);
            $this->call(UserSeeder::class, false, ['branch' => $branch]);
            $this->call(ReservationSettingsSeeder::class, false, ['branch' => $branch]);

            if (!App::environment('codecanyon')) {
                $this->call(AreaSeeder::class, false, ['branch' => $branch]);
                $this->call(TableSeeder::class, false, ['branch' => $branch]);
                $this->call(DeliveryExecutiveSeeder::class, false, ['branch' => $branch]);
                $this->call(MenuItemSeeder::class, false, ['branch' => $branch]);
                $this->call(OrderSeeder::class, false, ['branch' => $branch]);

                $restaurant->license_type = 'paid';
                $restaurant->save();

                RestaurantPayment::create([
                    'restaurant_id' => $restaurant->id,
                    'payment_date_time' => now()->toDateTimeString(),
                    'package_id' => package()->id,
                    'amount' => 99,
                    'status' => 'paid'
                ]);

            }
        }
    }

}
