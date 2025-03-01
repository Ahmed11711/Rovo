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

        Schema::create('file_storage', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');

            $table->string('path');
            $table->string('filename');
            $table->string('type', 50)->nullable();
            $table->unsignedInteger('size');
            $table->enum('storage_location', ['local', 'aws_s3', 'digitalocean', 'wasabi', 'minio'])->default('local');
            $table->timestamps();
        });

        Schema::create('file_storage_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filesystem');
            $table->text('auth_keys')->nullable();
            $table->enum('status', ['enabled', 'disabled'])->default('disabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['hash']);
        });
    }

};
