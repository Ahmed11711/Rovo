<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $check = Role::where('name', 'Admin')->first();
        if ($check) {
            $users = User::withoutGlobalScopes()->role('Admin')->select('id', 'restaurant_id')->get();
       
            foreach ($users as $user) {
                $user->syncRoles('Admin_'.$user->restaurant_id);
            }
        }

        $check = Role::where('name', 'Waiter')->first();
        if ($check) {
            $waiters = User::withoutGlobalScopes()->role('Waiter')->select('id', 'restaurant_id')->get();

            foreach ($waiters as $waiter) {
                $waiter->syncRoles('Waiter_'.$waiter->restaurant_id);
            }
        }

        $check = Role::where('name', 'Branch Head')->first();
        if ($check) {
            $branchHeads = User::withoutGlobalScopes()->role('Branch Head')->select('id', 'restaurant_id')->get();
      
            foreach ($branchHeads as $branchHead) {
                $branchHead->syncRoles('Branch Head_'.$branchHead->restaurant_id);
            }
        }
       
        $check = Role::where('name', 'Chef')->first();
        if ($check) {
            $chefs = User::withoutGlobalScopes()->role('Chef')->select('id', 'restaurant_id')->get();

            foreach ($chefs as $chef) {
                $chef->syncRoles('Chef_'.$chef->restaurant_id);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
