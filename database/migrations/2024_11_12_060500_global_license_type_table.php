<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::whenTableDoesntHaveColumn('global_settings', 'license_type', function (Blueprint $table) {
            $table->string('license_type')->nullable();
        });
        Schema::whenTableDoesntHaveColumn('global_settings', 'hide_cron_job', function (Blueprint $table) {
            $table->boolean('hide_cron_job')->default(0);
        });
        Schema::whenTableDoesntHaveColumn('global_settings', 'last_cron_run', function (Blueprint $table) {
            $table->timestamp('last_cron_run')->nullable();
        });
        Schema::whenTableDoesntHaveColumn('global_settings', 'system_update', function (Blueprint $table) {
            $table->boolean('system_update')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }

};
