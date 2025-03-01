<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\MenuItem;
use App\Models\ItemModifier;
use App\Models\ModifierGroup;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddModifierGroup extends Component
{
    use LivewireAlert;

    public $name;
    public $description;
    public $modifierOptions = [];
    public $menuItems;
    public $selectedMenuItems = [];
    public $search = '';
    public $isOpen = false;
    public $allMenuItems;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'modifierOptions.*.name' => 'required|string|max:255',
        'modifierOptions.*.price' => 'required|numeric|min:0',
        'modifierOptions.*.is_available' => 'required|boolean',
    ];

    protected $messages = [
        'name.required' => 'The name field is required.',
        'name.max' => 'The name may not be greater than 255 characters.',
        'modifierOptions.*.name.required' => 'Modifier option must have a name.',
        'modifierOptions.*.price.required' => 'Modifier option must have a price.',
        'modifierOptions.*.price.numeric' => 'Modifier option price must be a number.',
        'modifierOptions.*.price.min' => 'Modifier option price must be at least 0.',
    ];

    public function mount()
    {
        $this->resetValidation();
        $this->modifierOptions[] = $this->newModifierOption();
        $this->menuItems = MenuItem::all();
        $this->allMenuItems = $this->menuItems;
    }

    public function newModifierOption()
    {
        return [
            'id' => uniqid(), // Ensure each option has a unique identifier
            'name' => '',
            'price' => 0,
            'is_available' => true,
            'sort_order' => 0,
        ];
    }

    public function updatedIsOpen($value)
    {
        if (!$value) {
            $this->reset(['search']);
            $this->updatedSearch();
        }
    }

    public function updatedSearch()
    {
        $this->menuItems = MenuItem::where('item_name', 'like', '%' . $this->search . '%')->get();
    }

    public function addModifierOption()
    {
        $this->modifierOptions[] = $this->newModifierOption();
    }


    public function removeModifierOption($index)
    {
        unset($this->modifierOptions[$index]);
        $this->modifierOptions = array_values($this->modifierOptions); // Reindex the array
    }

    public function updateModifierOptionOrder($orderedIds)
    {
        $this->modifierOptions = collect($orderedIds)->map(function ($id) {
            return collect($this->modifierOptions)->firstWhere('id', $id['value']);
        })->toArray();
    }

    public function toggleSelectItem($item)
    {
        $itemId = $item['id'];

        if (($key = array_search($itemId, $this->selectedMenuItems)) !== false) {
            unset($this->selectedMenuItems[$key]);
        } else {
            $this->selectedMenuItems[] = $itemId;
        }
        $this->selectedMenuItems = array_values($this->selectedMenuItems); // Reindex the array
    }

    public function submitForm()
    {
        $this->validate();

        $modifierGroup = ModifierGroup::create([
            'name' => $this->name,
            'description' => $this->description,
            'branch_id' => branch()->id,
        ]);

        $modifierGroup->options()->createMany($this->modifierOptions);

        foreach ($this->selectedMenuItems as $menuItemId) {
            ItemModifier::create([
                'menu_item_id' => $menuItemId,
                'modifier_group_id' => $modifierGroup->id,
            ]);
        }

        $this->dispatch('hideAddModifierGroupModal');
        $this->reset(['name', 'description', 'modifierOptions', 'selectedMenuItems', 'search', 'isOpen']);

        $this->alert('success', __('messages.ModifierGroupAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.add-modifier-group');
    }
}
