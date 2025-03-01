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
        if (!Schema::hasColumn('orders', 'discount_type')) {
            Schema::table('orders', function (Blueprint $table) {
            $table->string('discount_type')->nullable();
            $table->double('discount_value', 16, 2)->nullable();
            $table->double('discount_amount', 16, 2)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'discount_value', 'discount_amount']);
        });
    }
};
