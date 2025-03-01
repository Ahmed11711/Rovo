<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Restaurant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->longText('about_us')->nullable();
        });

        $defaultAboutUs = Restaurant::ABOUT_US_DEFAULT_TEXT;

        Restaurant::all()->each(function ($restaurant) use ($defaultAboutUs) {
            $restaurant->about_us = $defaultAboutUs;
            $restaurant->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('about_us');
        });
    }
};
