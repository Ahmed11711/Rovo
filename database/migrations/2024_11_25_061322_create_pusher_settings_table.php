<?php

use App\Models\PusherSetting;
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
        Schema::create('pusher_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('beamer_status')->default(false);
            $table->string('instance_id')->nullable();
            $table->string('beam_secret')->nullable();
            $table->timestamps();
        });

        $setting = new PusherSetting();
        $setting->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pusher_settings');
    }
};
