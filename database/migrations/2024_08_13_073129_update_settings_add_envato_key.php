<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = config('froiden_envato.setting');
        $settingTable = (new $setting)->getTable();

        Schema::table($settingTable, function (Blueprint $table) use ($settingTable) {
            if (!Schema::hasColumn($settingTable, 'purchase_code')) {
                $table->string('purchase_code', 80)->nullable();
                $table->timestamp('supported_until')->nullable();
                $table->timestamp('last_license_verified_at')->nullable()->default(null);
            }
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
