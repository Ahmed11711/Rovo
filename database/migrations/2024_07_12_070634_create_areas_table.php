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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->timestamps();
        });

        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_code');
            $table->string('hash');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('available_status', ['available', 'reserved', 'running'])->default('available');

            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('seating_capacity', false, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
        Schema::dropIfExists('areas');
    }

};
