<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSettingsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($branch): void
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($daysOfWeek as $day) {
            DB::table('reservation_settings')->insert([
                [
                    'day_of_week' => $day,
                    'time_slot_start' => '08:00:00',
                    'time_slot_end' => '11:00:00',
                    'time_slot_difference' => 30,
                    'slot_type' => 'Breakfast',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => $branch->id,
                ],
                [
                    'day_of_week' => $day,
                    'time_slot_start' => '12:00:00',
                    'time_slot_end' => '17:00:00',
                    'time_slot_difference' => 60,
                    'slot_type' => 'Lunch',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => $branch->id,
                ],
                [
                    'day_of_week' => $day,
                    'time_slot_start' => '18:00:00',
                    'time_slot_end' => '22:00:00',
                    'time_slot_difference' => 60,
                    'slot_type' => 'Dinner',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'branch_id' => $branch->id,
                ]
            ]);
        }
    }

}
