<?php

namespace App\Livewire\Forms;

use App\Helper\Files;
use App\Models\ItemCategory;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuItemVariation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddMenuItem extends Component
{

    use WithFileUploads, LivewireAlert;

    protected $listeners = ['refreshCategories'];

    public $inputs = [];
    public $i = 0;
    public $showItemPrice = true;
    public $showMenuCategoryModal = false;
    public $hasVariations = false;
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
    public $preparationTime;
    public $isAvailable = 1;

    public function mount()
    {
        $this->categoryList = ItemCategory::all();
        $this->menus = Menu::all();
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

        $menuItem = MenuItem::create([
            'item_name' => $this->itemName,
            'price' => (!$this->hasVariations) ? $this->itemPrice : 0,
            'item_category_id' => $this->itemCategory,
            'description' => $this->itemDescription,
            'is_available' => (bool) $this->isAvailable,
            'type' => $this->itemType,
            'menu_id' => $this->menu,
            'preparation_time' => $this->preparationTime
        ]);

        if ($this->itemImage) {
            $menuItem->update([
                'image' => Files::uploadLocalOrS3($this->itemImage, 'item', width: 150),
            ]);
        }

        if ($this->hasVariations) {
            foreach ($this->variationName as $key => $value) {
                if (!empty($value)) {
                    $this->validate([
                        'variationPrice.' . $key => 'required|numeric'
                    ], [
                        'variationPrice.' . $key . '.required' => __('validation.variationPriceRequired'),
                    ]);

                    MenuItemVariation::create([
                        'variation' => $value,
                        'price' => $this->variationPrice[$key],
                        'menu_item_id' => $menuItem->id
                    ]);
                }
            }
        }

        $this->resetForm();

        $this->dispatch('menuItemAdded');
        $this->dispatch('refreshCategories');

        $this->alert('success', __('messages.menuItemAdded'), [
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
        return view('livewire.forms.add-menu-item');
    }
}
