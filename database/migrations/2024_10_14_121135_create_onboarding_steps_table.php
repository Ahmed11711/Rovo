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
        Schema::create('onboarding_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade'); // Foreign key for the restaurant or branch
            $table->boolean('add_area_completed')->default(false);   // Step 1: Add Area
            $table->boolean('add_table_completed')->default(false);  // Step 2: Add Table
            $table->boolean('add_menu_completed')->default(false);   // Step 3: Add Menu
            $table->boolean('add_menu_items_completed')->default(false); // Step 4: Add Menu Items
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_steps');
    }

};
