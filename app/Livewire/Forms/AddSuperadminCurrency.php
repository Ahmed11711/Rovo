<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\GlobalCurrency;

class AddSuperadminCurrency extends Component
{
    public $currencyName;
    public $currencySymbol;
    public $currencyCode;
    public $currencyPosition;
    public $thousandSeparator;
    public $decimalSeparator;
    public int $numberOfdecimals;

    public function mount()
    {
        $this->currencyPosition = 'left';
        $this->thousandSeparator = ',';
        $this->decimalSeparator = '.';
        $this->numberOfdecimals = '2';
    }

    public function submitForm()
    {
        $this->validate([
            'currencyName' => 'required',
            'currencySymbol' => 'required',
            'currencyCode' => 'required',
        ]);

        $currency = new GlobalCurrency();
        $currency->currency_name = $this->currencyName;
        $currency->currency_symbol = $this->currencySymbol;
        $currency->currency_code = $this->currencyCode;
        $currency->currency_position = $this->currencyPosition;
        $currency->thousand_separator = $this->thousandSeparator;
        $currency->decimal_separator = $this->decimalSeparator;
        $currency->no_of_decimal = $this->numberOfdecimals;
        $currency->save();

        $this->dispatch('hideAddCurrency');
    }

    public function currencyFormat($amount)
    {
        $currency_position = $this->currencyPosition;
        $no_of_decimal = !is_null($this->numberOfdecimals) ? $this->numberOfdecimals : '0';
        $thousand_separator = !is_null($this->thousandSeparator) ? $this->thousandSeparator : '';
        $decimal_separator = !is_null($this->decimalSeparator) ? $this->decimalSeparator : '0';
        $currency_symbol = !is_null($this->currencySymbol) ? $this->currencySymbol : '';

        $amount = number_format($amount, $no_of_decimal, $decimal_separator, $thousand_separator);

        $amount = match ($currency_position) {
            'right' => $amount . $currency_symbol,
            'left_with_space' => $currency_symbol . ' ' . $amount,
            'right_with_space' => $amount . ' ' . $currency_symbol,
            default => $currency_symbol . $amount,
        };

        return $amount;
    }

    public function render()
    {
        return view('livewire.forms.add-superadmin-currency', [
            'sampleFormat' => $this->currencyFormat(12345.6789, null, true),
        ]);
    }
}
