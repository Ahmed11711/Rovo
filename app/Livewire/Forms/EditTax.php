<?php

namespace App\Livewire\Forms;

use Livewire\Component;

class EditTax extends Component
{

    public $tax;
    public $taxName;
    public $taxPercent;

    public function mount()
    {
        $this->taxName = $this->tax->tax_name;
        $this->taxPercent = $this->tax->tax_percent;
    }

    public function submitForm()
    {
        $this->validate([
            'taxName' => 'required',
            'taxPercent' => 'required|numeric'
        ]);

        $this->tax->tax_name = $this->taxName;
        $this->tax->tax_percent = $this->taxPercent;
        $this->tax->save();

        $this->dispatch('hideEditCurrency');
    }

    public function render()
    {
        return view('livewire.forms.edit-tax');
    }

}
