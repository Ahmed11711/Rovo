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

        if (!Schema::hasColumn($settingTable, 'email')) {
            Schema::table($settingTable, function (Blueprint $table) use ($settingTable) {
                $table->string('email')->nullable()->default(null);
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
