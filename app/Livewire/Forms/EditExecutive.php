<?php

namespace App\Livewire\Forms;

use App\Models\DeliveryExecutive;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditExecutive extends Component
{

    use LivewireAlert;

    public $member;
    public $memberName;
    public $memberPhone;
    public $status;

    public function mount()
    {
        $this->memberName = $this->member->name;
        $this->memberPhone = $this->member->phone;
        $this->status = $this->member->status;
    }

    public function submitForm()
    {
        $this->validate([
            'memberName' => 'required',
            'memberPhone' => 'required|unique:delivery_executives,phone,' . $this->member->id
        ]);

        DeliveryExecutive::where('id', $this->member->id)->update([
            'name' => $this->memberName,
            'phone' => $this->memberPhone,
            'status' => $this->status,
        ]);

        // Reset the value
        $this->memberName = '';
        $this->memberPhone = '';
        $this->status = '';

        $this->dispatch('hideEditStaff');
        
        $this->alert('success', __('messages.memberUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }
    
    public function render()
    {
        return view('livewire.forms.edit-executive');
    }

}
