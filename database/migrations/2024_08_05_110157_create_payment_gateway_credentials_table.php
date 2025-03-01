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
        Schema::create('payment_gateway_credentials', function (Blueprint $table) {
            $table->id();
            
            $table->text('razorpay_key')->nullable();
            $table->text('razorpay_secret')->nullable();
            $table->boolean('razorpay_status')->default(false);

            $table->text('stripe_key')->nullable();
            $table->text('stripe_secret')->nullable();
            $table->boolean('stripe_status')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_credentials');
    }

};
