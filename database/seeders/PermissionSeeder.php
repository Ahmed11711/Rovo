<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuModule = Module::where('name', 'Menu')->first();
        $menuItemModule = Module::where('name', 'Menu Item')->first();
        $itemCategoryModule = Module::where('name', 'Item Category')->first();
        $areaModule = Module::where('name', 'Area')->first();
        $tableModule = Module::where('name', 'Table')->first();
        $reservationModule = Module::where('name', 'Reservation')->first();
        $kotModule = Module::where('name', 'KOT')->first();
        $orderModule = Module::where('name', 'Order')->first();
        $customerModule = Module::where('name', 'Customer')->first();
        $staffModule = Module::where('name', 'Staff')->first();
        $paymentModule = Module::where('name', 'Payment')->first();
        $reportModule = Module::where('name', 'Report')->first();
        $settingsModule = Module::where('name', 'Settings')->first();
        $deliveryExecutiveModule = Module::where('name', 'Delivery Executive')->first();
        $waiterRequestModule = Module::where('name', 'Waiter Request')->first();
        $permissions = [
            ['guard_name' => 'web', 'name' => 'Create Menu', 'module_id' => $menuModule->id],
            ['guard_name' => 'web', 'name' => 'Show Menu', 'module_id' => $menuModule->id],
            ['guard_name' => 'web', 'name' => 'Update Menu', 'module_id' => $menuModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Menu', 'module_id' => $menuModule->id],
            
            ['guard_name' => 'web', 'name' => 'Create Menu Item', 'module_id' => $menuItemModule->id],
            ['guard_name' => 'web', 'name' => 'Show Menu Item', 'module_id' => $menuItemModule->id],
            ['guard_name' => 'web', 'name' => 'Update Menu Item', 'module_id' => $menuItemModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Menu Item', 'module_id' => $menuItemModule->id],

            ['guard_name' => 'web', 'name' => 'Create Item Category', 'module_id' => $itemCategoryModule->id],
            ['guard_name' => 'web', 'name' => 'Show Item Category', 'module_id' => $itemCategoryModule->id],
            ['guard_name' => 'web', 'name' => 'Update Item Category', 'module_id' => $itemCategoryModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Item Category', 'module_id' => $itemCategoryModule->id],

            ['guard_name' => 'web', 'name' => 'Create Area', 'module_id' => $areaModule->id],
            ['guard_name' => 'web', 'name' => 'Show Area', 'module_id' => $areaModule->id],
            ['guard_name' => 'web', 'name' => 'Update Area', 'module_id' => $areaModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Area', 'module_id' => $areaModule->id],

            ['guard_name' => 'web', 'name' => 'Create Table', 'module_id' => $tableModule->id],
            ['guard_name' => 'web', 'name' => 'Show Table', 'module_id' => $tableModule->id],
            ['guard_name' => 'web', 'name' => 'Update Table', 'module_id' => $tableModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Table', 'module_id' => $tableModule->id],

            ['guard_name' => 'web', 'name' => 'Create Reservation', 'module_id' => $reservationModule->id],
            ['guard_name' => 'web', 'name' => 'Show Reservation', 'module_id' => $reservationModule->id],
            ['guard_name' => 'web', 'name' => 'Update Reservation', 'module_id' => $reservationModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Reservation', 'module_id' => $reservationModule->id],

            ['guard_name' => 'web', 'name' => 'Manage KOT', 'module_id' => $kotModule->id],

            ['guard_name' => 'web', 'name' => 'Create Order', 'module_id' => $orderModule->id],
            ['guard_name' => 'web', 'name' => 'Show Order', 'module_id' => $orderModule->id],
            ['guard_name' => 'web', 'name' => 'Update Order', 'module_id' => $orderModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Order', 'module_id' => $orderModule->id],
            
            ['guard_name' => 'web', 'name' => 'Show Customer', 'module_id' => $customerModule->id],
            ['guard_name' => 'web', 'name' => 'Update Customer', 'module_id' => $customerModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Customer', 'module_id' => $customerModule->id],
            
            ['guard_name' => 'web', 'name' => 'Create Staff Member', 'module_id' => $staffModule->id],
            ['guard_name' => 'web', 'name' => 'Show Staff Member', 'module_id' => $staffModule->id],
            ['guard_name' => 'web', 'name' => 'Update Staff Member', 'module_id' => $staffModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Staff Member', 'module_id' => $staffModule->id],

            ['guard_name' => 'web', 'name' => 'Create Delivery Executive', 'module_id' => $deliveryExecutiveModule->id],
            ['guard_name' => 'web', 'name' => 'Show Delivery Executive', 'module_id' => $deliveryExecutiveModule->id],
            ['guard_name' => 'web', 'name' => 'Update Delivery Executive', 'module_id' => $deliveryExecutiveModule->id],
            ['guard_name' => 'web', 'name' => 'Delete Delivery Executive', 'module_id' => $deliveryExecutiveModule->id],

            ['guard_name' => 'web', 'name' => 'Show Payments', 'module_id' => $paymentModule->id],

            ['guard_name' => 'web', 'name' => 'Show Reports', 'module_id' => $reportModule->id],
            
            ['guard_name' => 'web', 'name' => 'Manage Settings', 'module_id' => $settingsModule->id],

            ['guard_name' => 'web', 'name' => 'Manage Waiter Request', 'module_id' => $waiterRequestModule->id],
        ];
                
        Permission::insert($permissions);

    }

}
