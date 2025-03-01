<?php

use App\Models\Restaurant;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable()->constrained('restaurants')->onDelete('cascade')->after('id');
            $table->string('display_name')->nullable()->after('name');
        });

        $restaurant = Restaurant::all();
        
        foreach ($restaurant as $restaurant) {

            $roles = ['Admin', 'Branch Head', 'Waiter', 'Chef'];
            foreach ($roles as $role) {
                $check = Role::where('restaurant_id', $restaurant->id)->where('name', $role.'_'.$restaurant->id)->first();
                if ($check) {
                    $check->update(['restaurant_id' => $restaurant->id, 'display_name' => $role]);
                } else {
                    Role::create(['name' => $role.'_'.$restaurant->id, 'restaurant_id' => $restaurant->id, 'guard_name' => 'web', 'display_name' => $role]);
                }
            }
        
            $adminRole = Role::where('name', 'Admin_'.$restaurant->id)->where('restaurant_id', $restaurant->id)->first();
            $branchHeadRole = Role::where('name', 'Branch Head_'.$restaurant->id)->where('restaurant_id', $restaurant->id)->first();

            $allPermissions = Permission::get()->pluck('name')->toArray();
            $adminRole->syncPermissions($allPermissions);
            $branchHeadRole->syncPermissions($allPermissions);
    
        }
    }

    public function down()
    {
        Role::whereNotNull('restaurant_id')->delete();

        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
            $table->dropColumn('restaurant_id');
        });

    }
}; 
