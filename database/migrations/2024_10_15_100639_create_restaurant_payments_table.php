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
        Schema::create('restaurant_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade'); // Foreign key to restaurants
            $table->double('amount', 16, 2);  // Fixed charge for the restaurant
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');  // Payment status
            $table->enum('payment_source', ['official_site', 'app_sumo'])->default('official_site');
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_date_time')->nullable();
            $table->timestamps();
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->enum('license_type', ['free', 'paid'])->default('free')->after('currency_id');
        });

        Schema::table('global_settings', function (Blueprint $table) {
            $table->string('theme_hex')->nullable();
            $table->string('theme_rgb')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['license_type']);
        });

        Schema::dropIfExists('restaurant_payments');
    }

};
