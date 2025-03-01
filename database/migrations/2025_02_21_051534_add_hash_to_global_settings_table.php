<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\GlobalSetting;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settingTable = 'global_settings';

        if (!Schema::hasColumn($settingTable, 'hash')) {
            Schema::table($settingTable, function (Blueprint $table) {
                $table->string('hash')->nullable();
            });
        }

        $setting = GlobalSetting::first();
        if ($setting) {
            $setting->hash = md5(microtime());
            $setting->save();
        }

        $subscriptionTable = 'global_subscriptions';

        if (!Schema::hasColumn($subscriptionTable, 'subscription_id')) {
            Schema::table($subscriptionTable, function (Blueprint $table) {
            $table->string('subscription_id')->nullable();
            $table->string('customer_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn('hash');
        });

        Schema::table('global_subscriptions', function (Blueprint $table) {
            $table->dropColumn('subscription_id');
            $table->dropColumn('customer_id');
        });
    }
};
