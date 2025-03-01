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
        Schema::create('item_modifiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_item_id')->nullable();
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('modifier_group_id')->nullable();
            $table->foreign('modifier_group_id')->references('id')->on('modifier_groups')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_required')->default(false);
            $table->boolean('allow_multiple_selection')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_modifiers');
    }
};
