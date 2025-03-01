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
                $table->string('yelp_link', 255)->nullable()->after('twitter_link');

            });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['yelp_link']);
        });
    }

};
