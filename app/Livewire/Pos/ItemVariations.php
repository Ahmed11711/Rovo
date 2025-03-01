<?php

namespace App\Livewire\Pos;

use Livewire\Component;

class ItemVariations extends Component
{

    public $menuItem;
    public $itemVariation;
    public $variationName;
    public $variationPrice;
    public $showEditVariationsModal = false;
    public $showDeleteVariationsModal = false;

    public function mount($menuItem)
    {
        $this->menuItem = $menuItem->load('variations', 'branch', 'branch.restaurant');
    }

    public function setItemVariation($id)
    {
        $this->dispatch('setPosVariation', variationId: $id);
    }

    public function render()
    {
        return view('livewire.pos.item-variations');
    }

}
