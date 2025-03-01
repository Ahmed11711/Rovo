<?php

use App\Models\NotificationSetting;
use App\Models\Restaurant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $checkCount = Restaurant::count();

        if ($checkCount > 0) {
            $restaurants = Restaurant::select('id')->get();

            foreach ($restaurants as $restaurant) {
                $notificationTypes = [
                    [
                        'type' => 'staff_welcome',
                        'send_email' => 1,
                        'restaurant_id' => $restaurant->id
                    ],
                ];

                NotificationSetting::insert($notificationTypes);

            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

};
