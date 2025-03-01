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
            $table->string('facebook_link', 255)->nullable();
            $table->string('instagram_link', 255)->nullable();
            $table->string('twitter_link', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['facebook_link', 'instagram_link', 'twitter_link']);
        });
    }

};
