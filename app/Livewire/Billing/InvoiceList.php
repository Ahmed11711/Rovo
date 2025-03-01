<?php

namespace App\Livewire\Billing;

use Livewire\Component;

class InvoiceList extends Component
{
    public $search;

    public function render()
    {
        return view('livewire.billing.invoice-list');
    }
}
