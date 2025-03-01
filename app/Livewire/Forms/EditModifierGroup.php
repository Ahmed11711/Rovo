<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\MenuItem;
use App\Models\ItemModifier;
use App\Models\ModifierGroup;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditModifierGroup extends Component
{
    use LivewireAlert;
    public $name;
    public $description;
    public $modifierOptions = [];
    public $menuItems;
    public $selectedMenuItem;
    public $modifierGroupId;


    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'modifierOptions.*.name' => 'required|string|max:255',
        'modifierOptions.*.price' => 'required|numeric|min:0',
        'modifierOptions.*.is_available' => 'required|boolean',
        'modifierOptions.*.sort_order' => 'required|integer|min:0',
    ];

    protected $messages = [
        'name.required' => 'The name field is required.',
        'name.max' => 'The name may not be greater than 255 characters.',
        'modifierOptions.*.name.required' => 'Modifier option must have a name.',
        'modifierOptions.*.price.required' => 'Modifier option must have a price.',
        'modifierOptions.*.price.numeric' => 'Modifier option price must be a number.',
        'modifierOptions.*.price.min' => 'Modifier option price must be at least 0.',
    ];

    public function mount($id)
    {
        $modifierGroup = ModifierGroup::with(['options', 'itemModifiers'])->findOrFail($id);
        $this->name = $modifierGroup->name;
        $this->description = $modifierGroup->description;
        $this->modifierGroupId = $modifierGroup->id;
        $this->modifierOptions = $modifierGroup->options->map(function ($option) {
            return [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price,
                'is_available' => (bool) $option->is_available,
                'sort_order' => $option->sort_order,
            ];
        })->toArray();
        $this->menuItems = MenuItem::all();

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

    public function removeModifierOption($index)
    {
        unset($this->modifierOptions[$index]);
        $this->modifierOptions = array_values($this->modifierOptions); // Re-index array
    }


    public function addModifierOption()
    {
        $this->modifierOptions[] = $this->newModifierOption();
    }


    public function updateModifierOptionOrder($orderedIds)
    {
        $this->modifierOptions = collect($orderedIds)->map(function ($id) {
            return collect($this->modifierOptions)->firstWhere('id', $id['value']);
        })->toArray();
    }

    public function submitForm()
    {
        $this->validate();

        $modifierGroup = ModifierGroup::findOrFail($this->modifierGroupId);
        $modifierGroup->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $modifierGroup->options()->delete();
        $modifierGroup->options()->createMany($this->modifierOptions);

        $this->dispatch('hideEditModifierGroupModal');

        $this->alert('success', __('messages.ModifierGroupUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }


    public function render()
    {
        return view('livewire.forms.edit-modifier-group');
    }
}
