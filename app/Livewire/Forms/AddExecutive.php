<?php

namespace App\Livewire\Forms;

use App\Models\DeliveryExecutive;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddExecutive extends Component
{

    use LivewireAlert;

    public $memberName;
    public $memberPhone;
    public $status = 'available';

    public function submitForm()
    {
        $this->validate([
            'memberName' => 'required',
            'memberPhone' => 'required|unique:delivery_executives,phone'
        ]);

        DeliveryExecutive::create([
            'name' => $this->memberName,
            'phone' => $this->memberPhone,
            'status' => $this->status,
        ]);

        // Reset the value
        $this->memberName = '';
        $this->memberPhone = '';
        $this->status = '';

        $this->dispatch('hideAddStaff');
        
        $this->alert('success', __('messages.memberAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.add-executive');
    }

}
