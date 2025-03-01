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
        Schema::table('kots', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('order_id');
        });

        Schema::table('kot_items', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('kot_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('order_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kots', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });

        Schema::table('kot_items', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });

    }
};
