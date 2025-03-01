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
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->boolean('is_cash_payment_enabled')->default(false)->after('is_pickup_payment_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
             $table->dropColumn('is_cash_payment_enabled');

        });
    }

};
