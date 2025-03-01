<?php

namespace App\Livewire\DeliveryExecutive;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Exports\DeliveryExecutiveExport;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryExecutiveList extends Component
{

    public $search;
    public $showAddMember = false;

    #[On('hideAddStaff')]
    public function hideAddStaff()
    {
        $this->showAddMember = false;
    }

    public function exportDeliveryExecutiveList()
    {
        if (!in_array('Export Report', restaurant_modules())) {
            $this->dispatch('showUpgradeLicense');
        } else {
            return Excel::download(new DeliveryExecutiveExport, 'delivery-executive-'.now()->toDateTimeString().'.xlsx');
        }
    }

    public function render()
    {
        return view('livewire.delivery-executive.delivery-executive-list');
    }

}
