<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\GlobalSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasColumn('global_settings', 'installed_url')){
            Schema::table('global_settings', function (Blueprint $table) {
                $table->tinyText('installed_url')->nullable();
            });
        }

        $setting = GlobalSetting::first();

        if($setting){
            $setting->installed_url = config('app.url');
            $setting->saveQuietly();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['installed_url']);

        });
    }
};
