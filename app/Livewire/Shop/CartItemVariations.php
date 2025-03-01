<?php

namespace App\Livewire\Shop;

use Livewire\Component;

class CartItemVariations extends Component
{

    public $menuItem;
    public $itemVariation;
    public $variationName;
    public $variationPrice;
    public $orderItemQty;
    public $showEditVariationsModal = false;
    public $showDeleteVariationsModal = false;
    
    public function render()
    {
        return view('livewire.shop.cart-item-variations');
    }

}
