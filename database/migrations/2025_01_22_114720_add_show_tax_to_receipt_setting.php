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
        Schema::table('receipt_settings', function (Blueprint $table) {
            $table->boolean('show_tax')->default(false)->after('show_restaurant_logo');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('receipt_settings', function (Blueprint $table) {
            $table->dropColumn('show_tax');
        });
    }
};
