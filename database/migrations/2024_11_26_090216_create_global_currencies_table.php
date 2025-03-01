<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;


class CreateGlobalCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('global_currencies')) {    
            Schema::create('global_currencies', function (Blueprint $table) {
                $table->id();
                $table->string('currency_name', 191);
                $table->string('currency_symbol', 191);
                $table->string('currency_code', 191);
                $table->double('exchange_rate')->nullable();
                $table->double('usd_price')->nullable();
                $table->enum('is_cryptocurrency', ['yes', 'no'])->default('no');
                $table->enum('currency_position', ['left', 'right', 'left_with_space', 'right_with_space'])->default('left');
                $table->unsignedInteger('no_of_decimal')->default(2);
                $table->string('thousand_separator', 191)->nullable();
                $table->string('decimal_separator', 191)->nullable();
                $table->enum('status', ['enable', 'disable'])->default('enable');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                });
        }

        if(!Schema::hasColumn('currencies', 'exchange_rate')) {
            Schema::table('currencies', function (Blueprint $table) {
                $table->double('exchange_rate')->nullable();
                $table->double('usd_price')->nullable();
                $table->enum('is_cryptocurrency', ['yes', 'no'])->default('no');
            });
        }

        Artisan::call('db:seed', [
            '--class' => 'GlobalCurrencySeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_currencies'); 
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('exchange_rate');
            $table->dropColumn('usd_price');
            $table->dropColumn('is_cryptocurrency');
        });
    }
} 