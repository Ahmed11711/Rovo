<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $settingTable = 'global_settings';

        if (!Schema::hasColumn($settingTable, 'last_license_verified_at')) {
            Schema::table($settingTable, function (Blueprint $table) use ($settingTable) {
                $table->timestamp('last_license_verified_at')->nullable()->default(null)->after('supported_until');
            });
        }

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
