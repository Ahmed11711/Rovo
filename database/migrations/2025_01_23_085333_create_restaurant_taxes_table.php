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
        Schema::create('restaurant_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            
            $table->string('tax_id')->nullable();
            $table->string('tax_name')->nullable();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_taxes');
    }

};
