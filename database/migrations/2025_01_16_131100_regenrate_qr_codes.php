<?php

use App\Livewire\Restaurant\RestaurantList;
use Illuminate\Database\Migrations\Migration;
use App\Models\Table;
use App\Models\Branch;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            $tables = Table::all();

            foreach ($tables as $table) {
                $table->generateQrCode();
            }

            $branches = Branch::all();

            foreach ($branches as $branch) {
                $branch->generateQrCode();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
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
