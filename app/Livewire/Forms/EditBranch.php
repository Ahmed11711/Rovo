<?php

namespace App\Livewire\Forms;

use App\Models\Branch;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditBranch extends Component
{

    use LivewireAlert;

    public $branchName;
    public $branchAddress;
    public $branch;

    public function mount()
    {
        $this->branchName = $this->branch->name;
        $this->branchAddress = $this->branch->address;
    }

    public function submitForm()
    {
        $this->validate([
            'branchName' => 'required|unique:branches,name,'.$this->branch->id.',id,restaurant_id,' . restaurant()->id,
            'branchAddress' => 'required'
        ]);

        Branch::where('id', $this->branch->id)->update([
            'name' => $this->branchName,
            'restaurant_id' => restaurant()->id,
            'address' => $this->branchAddress,
        ]);

        $this->dispatch('hideEditBranch');

        session(['branches' => Branch::get()]);

        $this->alert('success', __('messages.branchUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }
    
    public function render()
    {
        return view('livewire.forms.edit-branch');
    }

}
