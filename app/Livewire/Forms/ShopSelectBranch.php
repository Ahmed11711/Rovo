<?php

namespace App\Livewire\Forms;

use App\Models\Branch;
use Livewire\Component;

class ShopSelectBranch extends Component
{

    public $branches;
    public $restaurant;
    public $currentBranch;
    public $shopBranch;
    public function mount()
    {
        $this->branches = $this->restaurant->branches;

        // if (request()->branch && request()->branch != '') {
        //     $this->currentBranch = Branch::withoutGlobalScopes()->find(request()->branch);

        // } else {
        //     $this->currentBranch = $this->branches->first();
        // }

        $this->currentBranch = $this->shopBranch ?? $this->branches->first();
    }

    public function updateBranch($id)
    {
        $branch = Branch::withoutGlobalScopes()->find($id);

        $this->redirect(route('shop_restaurant', [$branch->restaurant->hash]).'?branch=' . $id);
    }

    public function render()
    {
        return view('livewire.forms.shop-select-branch');
    }

}
