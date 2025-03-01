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
          Schema::table('menu_items', function (Blueprint $table) {
              // Modify the 'type' column to include additional options
              $table->enum('type', ['veg', 'non-veg', 'egg', 'drink', 'other'])->default('veg')->change();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Revert the 'type' column back to its original definition
            $table->enum('type', ['veg', 'non-veg', 'egg'])->default('veg')->change();
        });
    }

};
