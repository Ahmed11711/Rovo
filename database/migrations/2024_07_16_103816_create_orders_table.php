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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('tax_name');
            $table->double('tax_percent', 16, 2);
            $table->timestamps();
        });


        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->dateTime('date_time');

            $table->unsignedBigInteger('table_id')->nullable();
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('number_of_pax')->nullable();

            $table->unsignedBigInteger('waiter_id')->nullable();
            $table->foreign('waiter_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->enum('status', ['draft', 'kot', 'billed', 'paid', 'canceled', 'payment_due'])->default('kot');

            $table->double('sub_total', 16, 2);
            $table->double('total', 16, 2);

            $table->double('amount_paid', 16, 2)->default(0);

            $table->timestamps();
        });

        Schema::create('kots', function (Blueprint $table) {
            $table->id();
            $table->string('kot_number');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->text('note')->nullable();

            $table->enum('status', ['in_kitchen', 'food_ready', 'served'])->default('in_kitchen');

            $table->timestamps();
        });

        Schema::create('kot_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kot_id');
            $table->foreign('kot_id')->references('id')->on('kots')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('menu_item_id');
            $table->unsignedBigInteger('menu_item_variation_id')->nullable();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
            $table->foreign('menu_item_variation_id')->references('id')->on('menu_item_variations')->onDelete('cascade');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('menu_item_id');
            $table->unsignedBigInteger('menu_item_variation_id')->nullable();
            $table->integer('quantity');
            $table->double('price', 16, 2);
            $table->double('amount', 16, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
            $table->foreign('menu_item_variation_id')->references('id')->on('menu_item_variations')->onDelete('cascade');
        });

        Schema::create('order_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_taxes');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('kot_items');
        Schema::dropIfExists('kots');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('taxes');
    }

};
