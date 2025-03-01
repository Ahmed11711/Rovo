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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->boolean('is_waiter_request_enabled_on_desktop')->default(1);
            $table->boolean('is_waiter_request_enabled_on_mobile')->default(1);
            $table->boolean('is_waiter_request_enabled_open_by_qr')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('is_waiter_request_enabled_on_desktop');
            $table->dropColumn('is_waiter_request_enabled_on_mobile');
            $table->dropColumn('is_waiter_request_enabled_open_by_qr');
        });
    }

};
