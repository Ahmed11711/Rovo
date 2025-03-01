<?php

use App\Models\Flag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('email_settings', function (Blueprint $table) {
            $table->boolean('email_verified')->default(0);
            $table->boolean('verified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flags');
    }

};
