<?php

namespace App\Livewire\Forms;

use App\Models\Currency;
use Livewire\Component;

class AddCurrency extends Component
{

    public $restaurantCurrency;
    public $currencySymbol;
    public $currencyCode;
    public $currencyPosition;
    public $thousandSeparator;
    public $decimalSeparator;
    public int $numberOfDecimals;

    public function mount()
    {
        $this->currencyPosition = 'left';
        $this->thousandSeparator = ',';
        $this->decimalSeparator = '.';
        $this->numberOfDecimals = 2;
    }

    public function submitForm()
    {
        $this->validate([
            'restaurantCurrency' => 'required',
            'currencySymbol' => 'required',
            'currencyCode' => 'required',
        ]);

        $currency = new Currency();
        $currency->currency_name = $this->restaurantCurrency;
        $currency->currency_symbol = $this->currencySymbol;
        $currency->currency_code = $this->currencyCode;
        $currency->currency_position = $this->currencyPosition;
        $currency->thousand_separator = $this->thousandSeparator;
        $currency->decimal_separator = $this->decimalSeparator;
        $currency->no_of_decimal = $this->numberOfDecimals;
        $currency->save();

        $this->dispatch('hideAddCurrency');
    }

    public function currencyFormat($amount)
    {
        $currency_position = $this->currencyPosition;
        $no_of_decimal = $this->numberOfDecimals ?? 0;
        $thousand_separator = $this->thousandSeparator ?? '';
        $decimal_separator = $this->decimalSeparator ?? '0';
        $currency_symbol = $this->currencySymbol ?? '';

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
        return view('livewire.forms.add-currency', [
            'sampleFormat' => $this->currencyFormat(12345.6789),
        ]);
    }

}
