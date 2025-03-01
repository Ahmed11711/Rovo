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
        Schema::table('restaurant_payments', function (Blueprint $table) {
            $table->string('stripe_payment_intent')->nullable();
            $table->text('stripe_session_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_payments', function (Blueprint $table) {
            $table->dropColumn('stripe_payment_intent');
            $table->dropColumn('stripe_session_id');
        });
    }

};
