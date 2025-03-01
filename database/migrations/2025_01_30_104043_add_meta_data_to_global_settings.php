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
        Schema::table('global_settings', function (Blueprint $table) {
                $table->string('meta_keyword', 255)->nullable();
                $table->longText('meta_description')->nullable();

        });

         Schema::table('restaurants', function (Blueprint $table) {
            $table->string('meta_keyword', 255)->nullable();
            $table->longText('meta_description')->nullable();
         });

    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['meta_keyword', 'meta_description']);
        });

         Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['meta_keyword', 'meta_description']);
         });

    }

};
