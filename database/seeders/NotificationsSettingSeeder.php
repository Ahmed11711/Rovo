<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationsSettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($restaurant): void
    {
        $notificationTypes = [
            [
                'type' => 'order_received',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'reservation_confirmed',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'new_reservation',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'order_bill_sent',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ],
            [
                'type' => 'staff_welcome',
                'send_email' => 1,
                'restaurant_id' => $restaurant->id
            ]
        ];

        NotificationSetting::insert($notificationTypes);
    }

}
