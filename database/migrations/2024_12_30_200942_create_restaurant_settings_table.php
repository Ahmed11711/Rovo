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
            $table->boolean('requires_approval_after_signup')->default(false);
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->enum('approval_status', ['Pending', 'Approved', 'Rejected'])->default('Approved');
            $table->text('rejection_reason')->nullable();
        });

        cache()->forget('global_setting');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn('requires_approval_after_signup');
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'rejection_reason']);
        });
    }
};
