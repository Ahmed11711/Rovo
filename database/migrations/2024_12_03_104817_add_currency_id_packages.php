<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\GlobalCurrency;
use App\Models\Package;
use App\Models\RestaurantPayment;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->constrained('global_currencies')->onDelete('cascade');
        });

        Schema::table('restaurant_payments', function (Blueprint $table) {
            $table->foreignId('package_id')->nullable()->constrained('packages')->onDelete('cascade');
        });

        $defaultCurrency = GlobalCurrency::first();
        $defaultPackage = Package::first();

        if ($defaultCurrency) {
            Package::whereNull('currency_id')->update(['currency_id' => $defaultCurrency->id]);
        }

        if ($defaultPackage) {
            RestaurantPayment::whereNull('package_id')->update(['package_id' => $defaultPackage->id]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');
        });

        Schema::table('restaurant_payments', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};
