<?php

namespace App\Livewire\Forms;

use App\Models\Menu;
use App\Helper\Files;
use Livewire\Component;
use App\Models\MenuItem;
use App\Models\ItemCategory;
use Livewire\WithFileUploads;
use App\Models\MenuItemVariation;
use App\Scopes\AvailableMenuItemScope;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditMenuItem extends Component
{

    use WithFileUploads, LivewireAlert;

    protected $listeners = ['refreshCategories'];

    public $inputs = [];
    public int $i = 0;
    public bool $showItemPrice = true;
    public bool $hasVariations = false;
    public $menu;
    public $itemName;
    public $itemCategory;
    public $itemPrice;
    public $itemDescription;
    public $itemType = 'veg';
    public $itemImage;
    public $categoryList = [];
    public $menus = [];
    public $variationName = [];
    public $variationPrice = [];
    public $menuItem;
    public $preparationTime;
    public $isAvailable;

    public function mount()
    {
        $this->categoryList = ItemCategory::all();
        $this->menus = Menu::all();
        $this->menu = $this->menuItem->menu_id;
        $this->itemName = $this->menuItem->item_name;
        $this->itemCategory = $this->menuItem->item_category_id;
        $this->itemPrice = $this->menuItem->price;
        $this->preparationTime = $this->menuItem->preparation_time;
        $this->itemDescription = $this->menuItem->description;
        $this->itemType = $this->menuItem->type;
        $this->hasVariations = ($this->menuItem->variations->count() > 0);
        $this->showItemPrice = ($this->menuItem->variations->count() == 0);
        $this->isAvailable = $this->menuItem->is_available;

        foreach ($this->menuItem->variations as $key => $value) {
            $this->variationName[$key] = $value->variation;
            $this->variationPrice[$key] = $value->price;
            $this->i = $key + 1;
            array_push($this->inputs, $this->i);
        }
    }

    public function addMoreField($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);

        if (count($this->inputs) > 0) {
            $this->showItemPrice = false;
        }
    }

    public function removeField($i)
    {
        unset($this->inputs[$i]);
    }

    public function checkVariations()
    {
        if ($this->hasVariations) {
            $this->showItemPrice = false;

            if (count($this->inputs) == 0) {
                $this->addMoreField($this->i);
            }
        } else {
            $this->showItemPrice = true;
        }
    }

    public function refreshCategories()
    {
        $this->categoryList = ItemCategory::all();
    }

    public function submitForm()
    {
        $this->validate([
            'itemName' => 'required',
            'itemPrice' => 'required_if:hasVariations,false',
            'itemCategory' => 'required',
            'menu' => 'required',
            'isAvailable' => 'required|boolean',
        ]);
        
        MenuItem::withoutGlobalScope(AvailableMenuItemScope::class)->where('id', $this->menuItem->id)->update([
            'item_name' => $this->itemName,
            'price' => (!$this->hasVariations) ? $this->itemPrice : 0,
            'item_category_id' => $this->itemCategory,
            'description' => $this->itemDescription,
            'type' => $this->itemType,
            'preparation_time' => $this->preparationTime,
            'menu_id' => $this->menu,
            'is_available' => $this->isAvailable,
        ]);

        if ($this->itemImage) {
            $this->menuItem->update([
                'image' => Files::uploadLocalOrS3($this->itemImage, 'item', width: 150),
            ]);
        }

        if ($this->hasVariations) {
            MenuItemVariation::where('menu_item_id', $this->menuItem->id)->delete();

            foreach ($this->inputs as $key => $value) {
                MenuItemVariation::create([
                    'variation' => $this->variationName[$key],
                    'price' => $this->variationPrice[$key],
                    'menu_item_id' => $this->menuItem->id
                ]);
            }
        }

        $this->dispatch('hideEditMenuItem');
        $this->dispatch('refreshMenus');
        $this->resetForm();

        $this->alert('success', __('messages.menuItemUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function resetForm()
    {
        $this->itemName = '';
        $this->menu = '';
        $this->itemCategory = '';
        $this->itemPrice = '';
        $this->itemDescription = '';
        $this->itemType = 'veg';
        $this->itemImage = null;
        $this->preparationTime = null;
        $this->variationName = [];
        $this->variationPrice = [];
        $this->isAvailable = null;
    }

    public function showMenuCategoryModal()
    {
        $this->dispatch('showMenuCategoryModal');
    }

    public function render()
    {
        return view('livewire.forms.edit-menu-item');
    }
}
