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
        Schema::create('stripe_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->dateTime('payment_date')->nullable();
            $table->double('amount', 16, 2)->nullable();
            $table->enum('payment_status', ['pending', 'requested', 'declined', 'completed'])->default('pending');
            $table->text('payment_error_response')->nullable();

            $table->string('stripe_payment_intent')->nullable();

            $table->text('stripe_session_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_payments');
    }

};
