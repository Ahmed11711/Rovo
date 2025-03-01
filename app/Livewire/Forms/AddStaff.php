<?php

namespace App\Livewire\Forms;

use App\Models\Role;
use App\Models\User;
use App\Notifications\StaffWelcomeEmail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddStaff extends Component
{

    use LivewireAlert;

    public $roles;
    public $memberName;
    public $memberEmail;
    public $memberRole;
    public $memberPassword;

    public function mount()
    {
        $this->roles = Role::where('display_name', '<>', 'Super Admin')->get();
        $this->memberRole = $this->roles->first()->name;
    }

    public function submitForm()
    {
        $this->validate([
            'memberName' => 'required',
            'memberPassword' => 'required',
            'memberEmail' => 'required|unique:users,email'
        ]);

        $user = User::create([
            'name' => $this->memberName,
            'email' => $this->memberEmail,
            'password' => bcrypt($this->memberPassword),
        ]);

        $user->assignRole($this->memberRole);

        $user->notify(new StaffWelcomeEmail($user->restaurant, $this->memberPassword));

        // Reset the value
        $this->memberName = '';
        $this->memberEmail = '';
        $this->memberRole = '';
        $this->memberPassword = '';

        $this->dispatch('hideAddStaff');

        $this->alert('success', __('messages.memberAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.add-staff');
    }

}
