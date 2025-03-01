<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\StorageSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        StorageSetting::firstOrCreate([
            'filesystem' => 'local',
            'status' => 'enabled',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        StorageSetting::where('filesystem', 'local')->delete();
    }
};
