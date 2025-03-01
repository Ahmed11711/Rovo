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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->boolean('allow_customer_delivery_orders')->default(true);
            $table->boolean('allow_customer_pickup_orders')->default(true);
            $table->boolean('allow_customer_orders')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('allow_customer_delivery_orders');
            $table->dropColumn('allow_customer_pickup_orders');
            $table->dropColumn('allow_customer_orders');
        });
    }
};
