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
        Schema::create('item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->string('item_name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['veg', 'non-veg', 'egg'])->default('veg');
            $table->double('price', 16, 2)->nullable();

            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('item_category_id');
            $table->foreign('item_category_id')->references('id')->on('item_categories')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });


        Schema::create('menu_item_variations', function (Blueprint $table) {
            $table->id();

            $table->string('variation');
            $table->double('price', 16, 2);

            $table->unsignedBigInteger('menu_item_id');
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_variations');

        Schema::dropIfExists('menu_items');

        Schema::dropIfExists('menus');

        Schema::dropIfExists('item_categories');


    }

};
