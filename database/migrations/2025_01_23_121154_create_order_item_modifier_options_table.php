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
        Schema::create('order_item_modifier_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_item_id');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('modifier_option_id');
            $table->foreign('modifier_option_id')->references('id')->on('modifier_options')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('kot_item_modifier_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kot_item_id');
            $table->foreign('kot_item_id')->references('id')->on('kot_items')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('modifier_option_id');
            $table->foreign('modifier_option_id')->references('id')->on('modifier_options')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_modifier_options');
    }
};
