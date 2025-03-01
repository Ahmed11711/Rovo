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
            $table->boolean('hide_new_orders')->default(0)->after('country_id');
            $table->boolean('hide_new_reservations')->default(0)->after('hide_new_orders');
            $table->boolean('hide_new_waiter_request')->default(0)->after('hide_new_reservations');

        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('hide_new_orders');
            $table->dropColumn('hide_new_reservations');
            $table->dropColumn('hide_new_waiter_request');
        });
    }

};
