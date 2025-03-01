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
        Schema::table('currencies', function (Blueprint $table) {
            $table->enum('currency_position', ['left', 'right', 'left_with_space', 'right_with_space'])->default('left');
            $table->unsignedInteger('no_of_decimal')->default(2);
            $table->string('thousand_separator')->nullable()->default(',');
            $table->string('decimal_separator')->nullable()->default('.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
