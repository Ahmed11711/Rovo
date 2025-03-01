<?php

use App\Models\LanguageSetting;
use App\Models\Restaurant;
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
        Schema::create('language_settings', function (Blueprint $table) {
            $table->id();
            $table->string('language_code');
            $table->string('language_name');
            $table->string('flag_code');
            $table->boolean('active')->default(1);
            $table->boolean('is_rtl')->default(0);
            $table->timestamps();
        });

        Schema::table('global_settings', function (Blueprint $table) {
            $table->string('locale')->default('en');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('locale')->default('en');
        });

        $restaurant = Restaurant::withoutGlobalScopes()->count();

        if ($restaurant > 0) {
            LanguageSetting::insert(LanguageSetting::LANGUAGES);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['locale']);
        });

        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['locale']);
        });

        Schema::dropIfExists('language_settings');
    }

};
