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
        Schema::create('modifier_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modifier_group_id');
            $table->foreign('modifier_group_id')->references('id')->on('modifier_groups')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->double('price', 16, 2);
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_preselected')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modifier_options');
    }
};
