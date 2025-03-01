<?php

namespace App\Livewire\Forms;

use App\Models\Tax;
use Livewire\Component;

class AddTax extends Component
{

    public $taxName;
    public $taxPercent;

    public function submitForm()
    {
        $this->validate([
            'taxName' => 'required',
            'taxPercent' => 'required|numeric'
        ]);

        $currency = new Tax();
        $currency->tax_name = $this->taxName;
        $currency->tax_percent = $this->taxPercent;
        $currency->save();

        $this->dispatch('hideAddCurrency');
    }

    public function render()
    {
        return view('livewire.forms.add-tax');
    }

}
