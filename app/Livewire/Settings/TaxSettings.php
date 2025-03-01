<?php

namespace App\Livewire\Settings;

use App\Models\Tax;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class TaxSettings extends Component
{

    use LivewireAlert;

    protected $listeners = ['refreshTaxes' => 'mount'];

    public $taxes;
    public $tax;
    public $showEditCurrencyModal = false;
    public $showAddCurrencyModal = false;
    public $confirmDeleteCurrencyModal = false;

    public function mount()
    {
        $this->taxes = Tax::get();
    }

    public function showAddCurrency()
    {
        $this->showAddCurrencyModal = true;
    }

    public function showEditCurrency($id)
    {
        $this->tax = Tax::findOrFail($id);
        $this->showEditCurrencyModal = true;
    }

    public function showDeleteCurrency($id)
    {
        $this->tax = Tax::findOrFail($id);
        $this->confirmDeleteCurrencyModal = true;
    }

    public function deleteCurrency($id)
    {
        Tax::destroy($id);
        $this->tax = null;

        $this->confirmDeleteCurrencyModal = false;

        $this->dispatch('refreshTaxes');

        $this->alert('success', __('messages.taxDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    #[On('hideEditCurrency')]
    public function hideEditCurrency()
    {
        $this->showEditCurrencyModal = false;
        $this->dispatch('refreshTaxes');
    }

    #[On('hideAddCurrency')]
    public function hideAddCurrency()
    {
        $this->showAddCurrencyModal = false;
        $this->dispatch('refreshTaxes');
    }
    
    public function render()
    {
        return view('livewire.settings.tax-settings');
    }

}
