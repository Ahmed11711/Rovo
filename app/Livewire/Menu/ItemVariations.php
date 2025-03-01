<?php

namespace App\Livewire\Menu;

use App\Models\MenuItemVariation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ItemVariations extends Component
{

    use LivewireAlert;

    public $menuItem;
    public $itemVariation;
    public $variationName;
    public $variationPrice;
    public $showEditVariationsModal = false;
    public $showDeleteVariationsModal = false;
    
    public function editVariation($id)
    {
        $this->showEditVariationsModal = true;
        $this->itemVariation = MenuItemVariation::findOrFail($id);
        $this->variationName = $this->itemVariation->variation;
        $this->variationPrice = $this->itemVariation->price;
    }

    public function deleteVariation($id)
    {
        $this->showDeleteVariationsModal = true;
        $this->itemVariation = MenuItemVariation::findOrFail($id);
    }

    public function deleteItemVariation($id)
    {

        MenuItemVariation::destroy($id);
        $this->showDeleteVariationsModal = false;

        $this->alert('success', __('messages.itemVariationDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function submitForm()
    {
        MenuItemVariation::where('id', $this->itemVariation->id)->update([
            'variation' => $this->variationName,
            'price' => $this->variationPrice
        ]);

        $this->showEditVariationsModal = false;
    }

    public function render()
    {
        return view('livewire.menu.item-variations');
    }

}
