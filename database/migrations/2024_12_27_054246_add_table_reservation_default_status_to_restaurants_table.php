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
        if (!Schema::hasColumn('restaurants', 'default_table_reservation_status')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->string('default_table_reservation_status')->default('Confirmed');
            });
        }

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('reservation_status', ['Pending', 'Confirmed', 'Checked_In', 'Cancelled', 'No_Show'])->default('Confirmed')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('default_table_reservation_status');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('reservation_status', ['Confirmed', 'Checked_In', 'Cancelled', 'No_Show'])->default('Confirmed')->change();
        });
    }
};
