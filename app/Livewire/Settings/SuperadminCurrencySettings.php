<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\GlobalCurrency;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Package;

class SuperadminCurrencySettings extends Component
{
    use LivewireAlert;

    protected $listeners = ['refreshCurrencies' => 'mount'];

    public $currencies;
    public $currency;
    public $showEditCurrencyModal = false;
    public $showAddCurrencyModal = false;
    public $confirmDeleteCurrencyModal = false;

    public function mount()
    {
        $this->currencies = GlobalCurrency::get();
    }

    public function showAddCurrency()
    {
        $this->showAddCurrencyModal = true;
    }

    public function showEditCurrency($id)
    {
        $this->currency = GlobalCurrency::findOrFail($id);
        $this->showEditCurrencyModal = true;
    }

    public function showDeleteCurrency($id)
    {
        $this->currency = GlobalCurrency::findOrFail($id);
        $this->confirmDeleteCurrencyModal = true;
    }

    public function deleteCurrency($id)
    {

        if (Package::where('currency_id', $id)->exists()) {
            $this->addError('currency_error', '<strong>' . __('messages.currencyCannotBeDeleted') . '</strong><ul><li class="py-2">' . __('messages.currencyIsUsedInPackages') . '</li></ul>');
            $this->confirmDeleteCurrencyModal = false;

            // $this->dispatch('refreshCurrencies');
            return;
        }

        GlobalCurrency::destroy($id);

        $this->currency = null;

        $this->confirmDeleteCurrencyModal = false;

        $this->dispatch('refreshCurrencies');

        $this->alert('success', __('messages.currencyDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->currencies->fresh();
    }

    #[On('hideEditCurrency')]
    public function hideEditCurrency()
    {
        $this->showEditCurrencyModal = false;
        $this->dispatch('refreshCurrencies');
    }

    #[On('hideAddCurrency')]
    public function hideAddCurrency()
    {
        $this->showAddCurrencyModal = false;
        $this->dispatch('refreshCurrencies');
    }

    public function render()
    {
        return view('livewire.settings.superadmin-currency-settings');
    }
}
