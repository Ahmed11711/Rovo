<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run($restaurant)
    {
        // Create global roles (not restaurant-specific)
        $adminRole = Role::create(['name' => 'Admin_'.$restaurant->id, 'display_name' => 'Admin', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id   ]);
        $branchHeadRole = Role::create(['name' => 'Branch Head_'.$restaurant->id, 'display_name' => 'Branch Head', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id]);
        $waiterRole = Role::create(['name' => 'Waiter_'.$restaurant->id, 'display_name' => 'Waiter', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id]);
        $chefRole = Role::create(['name' => 'Chef_'.$restaurant->id, 'display_name' => 'Chef', 'guard_name' => 'web', 'restaurant_id' => $restaurant->id]);

        $allPermissions = Permission::get()->pluck('name')->toArray();
        $adminRole->syncPermissions($allPermissions);
        $branchHeadRole->syncPermissions($allPermissions);
        // Restaurant-specific roles will be created when restaurants are created
    }
}
