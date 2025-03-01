<?php

namespace App\Livewire\Forms;

use App\Models\Area;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditArea extends Component
{

    use LivewireAlert;

    public $activeArea;
    public $areaName;

    public function mount()
    {
        $this->areaName = $this->activeArea->area_name;
    }

    public function submitForm()
    {
        $this->validate([
            'areaName' => 'required'
        ]);

        Area::where('id', $this->activeArea->id)->update([
            'area_name' => $this->areaName
        ]);

        // Reset the value
        $this->areaName = '';

        $this->dispatch('hideEditArea');

        $this->alert('success', __('messages.areaUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.edit-area');
    }

}
