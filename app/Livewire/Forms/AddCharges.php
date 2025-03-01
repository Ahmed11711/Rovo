<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\RestaurantCharge;

class AddCharges extends Component
{
    public $chargeId;
    public $chargeName;
    public $chargeType = 'percent';
    public $chargeValue;
    public $selectedOrderTypes = [];
    public $selectedChargeId;
    public $orderTypes = [];

    public function mount()
    {
        $this->orderTypes = [
            'dine_in' => __('modules.order.dine_in'),
            'pickup' => __('modules.order.pickup'),
            'delivery' => __('modules.order.delivery'),
        ];

        if ($this->selectedChargeId) {
            $charge = RestaurantCharge::find($this->selectedChargeId);
            $this->chargeName = $charge->charge_name;
            $this->chargeType = $charge->charge_type;
            $this->chargeValue = $charge->charge_value;
            $this->selectedOrderTypes = array_unique($charge->order_types ?? []);
        }
    }

    public function toggleSelectOrderType($orderType)
    {
        $this->selectedOrderTypes = in_array($orderType, $this->selectedOrderTypes)
            ? array_values(array_diff($this->selectedOrderTypes, [$orderType]))
            : array_unique([...$this->selectedOrderTypes, $orderType]);
    }

    public function submitForm()
    {
        $this->validate([
            'chargeName' => 'required|string|max:255',
            'chargeType' => 'required|in:percent,fixed',
            'chargeValue' => 'required|numeric|min:0',
        ]);

        $charge = RestaurantCharge::updateOrCreate(
            ['id' => $this->selectedChargeId],
            [
                'charge_name' => $this->chargeName,
                'charge_type' => $this->chargeType,
                'charge_value' => $this->chargeValue,
                'order_types' => array_values(array_unique($this->selectedOrderTypes)),
            ]
        );

        $this->dispatch('hideShowChargesForm');
    }

    public function render()
    {
        return view('livewire.forms.add-charges');
    }
}
