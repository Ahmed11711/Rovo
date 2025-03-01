<?php

namespace App\Livewire\Staff;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Exports\StaffExport;
use Maatwebsite\Excel\Facades\Excel;

class StaffList extends Component
{
    public $search;
    public $showAddMember = false;

    #[On('hideAddStaff')]
    public function hideAddStaff()
    {
        $this->showAddMember = false;
        $this->js('window.location.reload()');
    }

    public function exportStaffList()
    {
        if (!in_array('Export Report', restaurant_modules())) {
            $this->dispatch('showUpgradeLicense');
        } else {
            return Excel::download(new StaffExport, 'staff-' . now()->toDateTimeString() . '.xlsx');
        }
    }

    public function render()
    {
        return view('livewire.staff.staff-list');
    }

}
