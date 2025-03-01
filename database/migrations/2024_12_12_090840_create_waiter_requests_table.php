<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Module;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('waiter_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamps();
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->boolean('is_waiter_request_enabled')->default(true);
        });

        $checkModule = Module::count();
        $checkWaiterRequestModule = Module::where('name', 'Waiter Request')->first();

        if ($checkModule > 0 && !$checkWaiterRequestModule) {
            $modules = ['name' => 'Waiter Request'];

            $menuModule = Module::create($modules);

            $permissions = [
                ['guard_name' => 'web', 'name' => 'Manage Waiter Request', 'module_id' => $menuModule->id],
            ];

            Permission::insert($permissions);

            $adminRole = Role::where('name', 'Admin')->first();
            $branchHeadRole = Role::where('name', 'Branch Head')->first();

            $allPermissions = Permission::get()->pluck('name')->toArray();
            $adminRole->givePermissionTo($allPermissions);
            $branchHeadRole->givePermissionTo($allPermissions);

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiter_requests');

        $module = Module::where('name', 'Waiter Request')->first();
        if ($module) {
            $module->delete();
        }
    }
};
