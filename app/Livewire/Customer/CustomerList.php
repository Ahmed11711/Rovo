<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;


class CustomerList extends Component
{
    public $search;

    public function exportCustomerList()
    {
        if (!in_array('Export Report', restaurant_modules())) {
            $this->dispatch('showUpgradeLicense');
        } else {
            return Excel::download(new CustomerExport, 'customers-' . now()->toDateTimeString() . '.xlsx');
        }
    }

    public function render()
    {
        return view('livewire.customer.customer-list');
    }

}
