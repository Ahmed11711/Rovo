<?php

namespace App\Livewire\Staff;

use App\Models\Role;
use App\Models\User;
use App\Scopes\BranchScope;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class StaffTable extends Component
{

    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $search;
    public $customer;
    public $roles;
    public $showEditCustomerModal = false;
    public $confirmDeleteCustomerModal = false;
    public $showCustomerOrderModal = false;

    protected $listeners = ['refreshCustomers' => '$refresh'];

    public function mount()
    {
        $this->roles = Role::where('name', '<>', 'Super Admin')->get();
    }

    public function showEditCustomer($id)
    {
        $this->customer = User::withoutGlobalScopes()->where('restaurant_id', restaurant()->id)->findOrFail($id);
        $this->showEditCustomerModal = true;
    }

    #[On('hideEditStaff')]
    public function hideEditStaff()
    {
        $this->showEditCustomerModal = false;
        $this->js('window.location.reload()');
    }

    public function showDeleteCustomer($id)
    {
        $this->customer = User::findOrFail($id);
        $this->confirmDeleteCustomerModal = true;
    }

    public function deleteCustomer($id)
    {
        User::destroy($id);

        $this->confirmDeleteCustomerModal = false;

        $this->alert('success', __('messages.memberDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }
    
    public function setUserRole($role, $userID)
    {
        $employee = User::find($userID);
        $employee->syncRoles([$role]);
        $this->redirect(route('staff.index'), navigate: true);
    }

    #[On('hideEditCustomer')]
    public function hideEditCustomer()
    {
        $this->showEditCustomerModal = false;
    }

    public function render()
    {
        $query = User::withoutGlobalScope(BranchScope::class)
            ->where(function($q) {
                return $q->where('branch_id', branch()->id)
                    ->orWhereNull('branch_id');
            })
            ->where('restaurant_id', restaurant()->id)
        ->where(function($q) {
            return $q->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%');
        })
        ->paginate(10);

        return view('livewire.staff.staff-table', [
            'members' => $query
        ]);
    }

}
