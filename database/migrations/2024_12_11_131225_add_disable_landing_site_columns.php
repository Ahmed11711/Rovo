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
        Schema::table('global_settings', function (Blueprint $table) {
            $table->boolean('disable_landing_site')->default(false);
            $table->enum('landing_site_type', ['theme', 'custom'])->default('theme');
            $table->string('landing_site_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn('disable_landing_site');
            $table->dropColumn('landing_site_type');
            $table->dropColumn('landing_site_url');
        });
    }
};

