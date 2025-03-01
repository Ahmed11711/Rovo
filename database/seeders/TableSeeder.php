<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class TableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($branch): void
    {
        for ($i = 0; $i < 10; $i++) {
            $area = Area::inRandomOrder()->first();
            $tableCode = 'T-' . $i + 1;

            Table::withoutEvents(function () use ($branch, $area, $tableCode) {
                $table = Table::create([
                    'table_code' => $tableCode,
                    'area_id' => $area->id,
                    'seating_capacity' => rand(2, 8),
                    'hash' => md5(microtime() . rand(1, 99999999)),
                    'branch_id' => $branch->id,
                ]);

                $table->generateQrCode();
            });

        }

    }

}
