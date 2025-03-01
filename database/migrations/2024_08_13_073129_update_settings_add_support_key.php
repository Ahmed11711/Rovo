<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settingTable = 'global_settings';

        if (!Schema::hasColumn($settingTable, 'supported_until')) {
            Schema::table($settingTable, function (Blueprint $table) use ($settingTable) {
                $table->timestamp('supported_until')->nullable();
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

