<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->boolean('allow_dine_in_orders')->default(1)->after('allow_customer_orders');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('allow_dine_in_orders');
        });
    }
};
