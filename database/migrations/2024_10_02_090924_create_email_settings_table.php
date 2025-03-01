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
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mail_from_name')->nullable();
            $table->string('mail_from_email')->nullable();
            $table->enum('enable_queue', ['yes', 'no'])->default('no');
            $table->enum('mail_driver', ['mail', 'smtp'])->default('mail');
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_settings');
    }

};
