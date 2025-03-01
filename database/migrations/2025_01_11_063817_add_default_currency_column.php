<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\GlobalCurrency;
use App\Models\GlobalSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('default_currency_id')->nullable();
            $table->foreign('default_currency_id')->references('id')->on('global_currencies')->onDelete('cascade')->onUpdate('cascade');
        });

        $globalSetting = GlobalSetting::first();

        if ($globalSetting) {
            $globalSetting->default_currency_id = GlobalCurrency::first()->id;
            $globalSetting->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropForeign(['default_currency_id']);
            $table->dropColumn('default_currency_id');
        });
    }
};
