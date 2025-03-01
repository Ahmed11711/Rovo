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
            $table->string('webmanifest')->nullable();
        });


        Schema::table('global_settings', function (Blueprint $table) {
            $table->string('webmanifest')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('webmanifest');
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('webmanifest');
        });
    }

};

