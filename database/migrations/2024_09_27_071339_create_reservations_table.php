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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('table_id')->nullable();
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade')->onUpdate('cascade');
            
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('SET NULL')->onUpdate('cascade');

            $table->dateTime('reservation_date_time');
            $table->integer('party_size');

            $table->text('special_requests')->nullable();

            $table->enum('reservation_status', ['Confirmed', 'Checked_In', 'Cancelled', 'No_Show'])->default('Confirmed');
            $table->enum('reservation_slot_type', ['Breakfast', 'Lunch', 'Dinner']);
            
            $table->timestamps();
        });

        Schema::create('reservation_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('time_slot_start');
            $table->time('time_slot_end');
            $table->integer('time_slot_difference');
            $table->enum('slot_type', ['Breakfast', 'Lunch', 'Dinner']);
            $table->boolean('available')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unavailability');
        Schema::dropIfExists('reservation_settings');
        Schema::dropIfExists('reservations');
    }

};
