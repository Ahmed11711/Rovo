<?php

namespace App\Livewire\Forms;

use App\Models\Branch;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddBranch extends Component
{

    use LivewireAlert;

    public $branchName;
    public $branchAddress;

    private function checkBranchLimit(): bool
    {
        if (!in_array('Change Branch', restaurant_modules(), true)) {
            return false;
        }

        $restaurant = restaurant();
        $branchLimit = $restaurant->package->branch_limit;

        if (is_null($branchLimit) || $branchLimit === -1) {
            return true;
        }

        if ($branchLimit === 0 || $restaurant->branches()->count() >= $branchLimit) {
            return false;
        }

        return true;
    }

    public function submitForm()
    {
        if (!$this->checkBranchLimit()) {
            $this->alert('error', __('messages.invalidRequest'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
            return;
        }

        $this->validate([
            'branchName' => 'required|unique:branches,name,null,id,restaurant_id,' . restaurant()->id,
            'branchAddress' => 'required'
        ]);

        Branch::create([
            'name' => $this->branchName,
            'restaurant_id' => restaurant()->id,
            'address' => $this->branchAddress,
        ]);

        // Reset the value
        $this->branchName = '';
        $this->branchAddress = '';

        $this->dispatch('hideAddBranch');

        session(['branches' => Branch::get()]);

        $this->alert('success', __('messages.branchAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.add-branch');
    }

}
