<?php

use App\Models\Branch;
use App\Models\Restaurant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('restaurant_settings', 'restaurants');

        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');

            $table->string('name');
            $table->string('address')->nullable();
            
            $table->timestamps();
        });

        $branchesTables = [
            'areas',
            'item_categories',
            'kots',
            'menu_items',
            'menus',
            'order_items',
            'orders',
            'payments',
            'reservation_settings',
            'reservations',
            'tables',
            'users',
        ];

        
        foreach ($branchesTables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('id');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');
            });
        }

        $restaurantTables = [
            'payment_gateway_credentials',
            'taxes',
            'currencies',
            'customers',
            'notification_settings',
            'users'
        ];

        foreach ($restaurantTables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedBigInteger('restaurant_id')->nullable()->after('id');
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
            });
        }

        $restaurant = Restaurant::first();

        $branch = null;

        if ($restaurant) {
            $branch = Branch::create(['restaurant_id' => $restaurant->id, 'name' => $restaurant->name, 'address' => $restaurant->address]);

            foreach ($restaurantTables as $table) {
                DB::statement('UPDATE '.$table .' SET restaurant_id = ' . $restaurant->id);
            }

            foreach ($branchesTables as $table) {
                DB::statement('UPDATE '.$table .' SET branch_id = ' . $branch->id);
            }
            
        }

        Schema::table('global_settings', function (Blueprint $table) {
            $table->string('name');
            $table->string('logo')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $dbTables = [
        'areas',
        'item_categories',
        'kots',
        'menu_items',
        'menus',
        'order_items',
        'orders',
        'payments',
        'reservation_settings',
        'reservations',
        'tables',
        'users',
        ];

        foreach ($dbTables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn(['branch_id']);
            });
        }

         Schema::dropIfExists('branches');

    }

};
