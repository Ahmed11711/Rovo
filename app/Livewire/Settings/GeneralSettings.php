<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\RestaurantTax;
use App\Models\RestaurantCharge;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class GeneralSettings extends Component
{

    use LivewireAlert, WithPagination;

    public $settings;
    public $restaurantName;
    public $restaurantAddress;
    public $restaurantPhoneNumber;
    public $restaurantEmailAddress;
    public $taxName;
    public $taxId;
    public $showTax = false;
    public $taxFields = [];
    public $confirmDeleteTax = false;
    public $isSaveClicked = false;
    public $fieldId;
    public $fieldIndex;
    public $confirmDeleteTaxModal = false;
    public $showChargesForm = false;
    public $selectedChargeId;
    public $confirmDeleteChargeModal = false;

    public function mount()
    {
        $this->restaurantName = $this->settings->name;
        $this->restaurantAddress = $this->settings->address;
        $this->restaurantEmailAddress = $this->settings->email;
        $this->restaurantPhoneNumber = $this->settings->phone_number;
        $this->fatchData();
        if (empty($this->taxFields)) {
            $this->addMoreTaxFields();
        }
    }

    public function showForm($id = null)
    {
        $this->selectedChargeId = $id;
        $this->showChargesForm = true;
    }

    public function fatchData()
    {

        $reciptSetting = restaurant()->receiptSetting;
        $this->showTax = (bool) $reciptSetting->show_tax;
        $taxes = RestaurantTax::all();

        $this->taxFields = $taxes->map(function ($tax) {
            return [

                'taxId' => $tax->tax_id,
                'taxName' => $tax->tax_name,
                'id' => $tax->id
            ];
        })->toArray();
    }

    public function addMoreTaxFields()
    {
        $this->taxFields[] = ['taxId' => '', 'taxName' => '' ,'id' => null];
    }

    public function submitForm()
    {
        $this->validate([
            'restaurantName' => 'required',
            'restaurantPhoneNumber' => 'required',
            'restaurantEmailAddress' => 'required|email',
        ]);

        $this->settings->email = $this->restaurantEmailAddress;
        $this->settings->name = $this->restaurantName;
        $this->settings->phone_number = $this->restaurantPhoneNumber;
        $this->settings->address = $this->restaurantAddress;
        $this->settings->save();

        session()->forget(['restaurant', 'timezone', 'currency']);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    public function showConfirmationField($id = null, $index)
    {

        if (is_null($id)) {
            $this->removeLastTaxField($index);
        }
        else
        {
            $this->confirmDeleteTaxModal = true;
            $this->fieldId = $id;
            $this->fieldIndex = $index;
        }
    }

    public function deleteAndRemove($id, $index)
    {
        $this->deleteRecord($id);
        $this->removeLastTaxField($index);
        $this->reset(['fieldId', 'fieldIndex', 'confirmDeleteTaxModal']);
    }

    public function removeLastTaxField($index)
    {
        if (isset($this->taxFields[$index])) {
            unset($this->taxFields[$index]);
            $this->taxFields = array_values($this->taxFields);
        }
    }

    public function deleteRecord($id)
    {
        RestaurantTax::destroy($id);
        $this->confirmDeleteTax = false;
        session()->flash('message', 'Record deleted successfully.');
    }

    public function submitTax()
    {
        $this->taxFields = array_values(array_filter($this->taxFields, function ($field) {
            return !empty($field['taxName']) && !empty($field['taxId']);
        }));

        $this->validate([
        'taxFields.*.taxName' => 'required',
        'taxFields.*.taxId' => 'required',
        'showTax' => 'boolean',
        ]);

        $restaurantId = restaurant()->id;

        foreach ($this->taxFields as $field) {
            RestaurantTax::updateOrCreate(
            ['id' => $field['id']],
            [
                'restaurant_id' => $restaurantId,
                'tax_id' => $field['taxId'],
                'tax_name' => $field['taxName'],
            ]
            );
        }

        $reciptSetting = restaurant()->receiptSetting;
        $reciptSetting->show_tax = $this->showTax;
        $reciptSetting->save();

        $this->fatchData();
        $this->alert('success', __('messages.settingsUpdated'), [
        'toast' => true,
        'position' => 'top-end',
        'showCancelButton' => false,
        'cancelButtonText' => __('app.close'),
        ]);
    }
    #[On('hideShowChargesForm')]
    public function hideShowChargesForm()
    {
        $this->showChargesForm = false;
    }

    public function confirmDeleteCharge($id)
    {
        $this->confirmDeleteChargeModal = true;
        $this->selectedChargeId = $id;
    }

    public function deleteCharge($id)
    {
        RestaurantCharge::destroy($id);

        $this->selectedChargeId = null;
        $this->confirmDeleteChargeModal = false;

        $this->alert('success', __('messages.chargeDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.settings.general-settings', [
            'charges' => RestaurantCharge::paginate(5)
        ]);
    }

}
