<?php

use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_executives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['available', 'on_delivery', 'inactive'])->default('available');
            $table->timestamps();
        });

        $checkModule = Module::count();
        $checkDelvryModule = Module::where('name', 'Delivery Executive')->first();

        if ($checkModule > 0 && !$checkDelvryModule) {
            $modules = ['name' => 'Delivery Executive'];

            $menuModule = Module::create($modules);
    
            $permissions = [
                ['guard_name' => 'web', 'name' => 'Create Delivery Executive', 'module_id' => $menuModule->id],
                ['guard_name' => 'web', 'name' => 'Show Delivery Executive', 'module_id' => $menuModule->id],
                ['guard_name' => 'web', 'name' => 'Update Delivery Executive', 'module_id' => $menuModule->id],
                ['guard_name' => 'web', 'name' => 'Delete Delivery Executive', 'module_id' => $menuModule->id],
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
        Schema::dropIfExists('delivery_executives');

        $module = Module::where('name', 'Delivery Executive')->first();
        if ($module) {
            $module->delete();
        }
    }

};
