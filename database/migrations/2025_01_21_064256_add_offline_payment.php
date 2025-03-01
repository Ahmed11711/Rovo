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
            $table->boolean('is_qr_payment_enabled')->default(false);
            $table->boolean('is_offline_payment_enabled')->default(false);
            $table->string('offline_payment_detail')->nullable();
            $table->string('qr_code_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->dropColumn('is_qr_payment_enabled');
            $table->dropColumn('is_offline_payment_enabled');
            $table->dropColumn('offline_payment_detail');
            $table->dropColumn('qr_code_image');
        });
    }

};
