<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->char('countries_code', 2);
            $table->string('countries_name');
            $table->string('phonecode');

            // Indexes
            $table->primary(['id']);
            $table->index(['countries_code']);
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency_name');
            $table->string('currency_code');
            $table->string('currency_symbol');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }

};