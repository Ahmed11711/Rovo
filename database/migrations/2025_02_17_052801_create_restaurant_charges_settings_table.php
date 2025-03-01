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
        if (!Schema::hasTable('restaurant_charges')) {
            Schema::create('restaurant_charges', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
                $table->string('charge_name')->index();
                $table->enum('charge_type', ['percent', 'fixed'])->default('fixed');
                $table->double('charge_value', 16, 2)->nullable();
                $table->json('order_types')->comment('Supported order types: DineIn, Delivery, PickUp');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_charges')) {
            Schema::create('order_charges', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

                $table->unsignedBigInteger('charge_id');
                $table->foreign('charge_id')->references('id')->on('restaurant_charges')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_charges');
        Schema::dropIfExists('order_charges');
    }
};
