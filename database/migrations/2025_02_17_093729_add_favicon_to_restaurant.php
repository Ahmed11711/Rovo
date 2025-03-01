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
            $table->string('upload_fav_icon_android_chrome_192')->nullable();
            $table->string('upload_fav_icon_android_chrome_512')->nullable();
            $table->string('upload_fav_icon_apple_touch_icon')->nullable();
            $table->string('upload_favicon_16')->nullable();
            $table->string('upload_favicon_32')->nullable();
            $table->string('favicon')->nullable();
        });

        Schema::table('global_settings', function (Blueprint $table) {
            $table->string('upload_fav_icon_android_chrome_192')->nullable();
            $table->string('upload_fav_icon_android_chrome_512')->nullable();
            $table->string('upload_fav_icon_apple_touch_icon')->nullable();
            $table->string('upload_favicon_16')->nullable();
            $table->string('upload_favicon_32')->nullable();
            $table->string('favicon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('upload_fav_icon_android_chrome_192');
            $table->dropColumn('upload_fav_icon_android_chrome_512');
            $table->dropColumn('upload_fav_icon_apple_touch_icon');
            $table->dropColumn('upload_favicon_16');
            $table->dropColumn('upload_favicon_32');
            $table->dropColumn('favicon');
        });

        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn('upload_fav_icon_android_chrome_192');
            $table->dropColumn('upload_fav_icon_android_chrome_512');
            $table->dropColumn('upload_fav_icon_apple_touch_icon');
            $table->dropColumn('upload_favicon_16');
            $table->dropColumn('upload_favicon_32');
            $table->dropColumn('favicon');
        });
    }

};
