<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($branch): void
    {
        $areas = [
            [
                'area_name' => 'Lounge',
                'branch_id' => $branch->id,
            ],
            [
                'area_name' => 'Roof Top',
                'branch_id' => $branch->id,
            ],
            [
                'area_name' => 'Garden',
                'branch_id' => $branch->id,
            ]
        ];
        Area::insert($areas);
    }

}
