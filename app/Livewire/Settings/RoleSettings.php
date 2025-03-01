<?php

namespace App\Livewire\Settings;

use App\Models\Module;
use App\Models\Role;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class RoleSettings extends Component
{

    public $permissions;
    public $roles;

    public function mount()
    {
        $this->permissions = Module::with('permissions')->get();
        $this->roles = Role::where('display_name', '<>', 'Admin')->where('display_name', '<>', 'Super Admin')->get();
    }

    public function setPermission($roleID, $permissionID)
    {
        $role = Role::find($roleID);
        $role->givePermissionTo($permissionID);
    }

    public function removePermission($roleID, $permissionID)
    {
        $role = Role::find($roleID);
        $role->revokePermissionTo($permissionID);
    }

    public function render()
    {
        return view('livewire.settings.role-settings');
    }

}
