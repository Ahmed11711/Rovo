<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\MenuItem;
use App\Models\ItemModifier;
use App\Models\ModifierGroup;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditItemModifier extends Component
{
    use LivewireAlert;

    public $menuItems;
    public $modifierGroups;
    public $menuItemId;
    public $modifierGroupId;
    public $itemModifierId;
    public $isRequired = false;
    public $allowMultipleSelection = false;

    public function mount()
    {
        $this->menuItems = MenuItem::select('id', 'item_name')->get();
        $this->modifierGroups = ModifierGroup::select('id', 'name')->get();
        $this->loadItemModifier();
    }

    public function loadItemModifier()
    {
        $itemModifier = ItemModifier::findOrFail($this->itemModifierId);
        $this->menuItemId = $itemModifier->menu_item_id;
        $this->modifierGroupId = $itemModifier->modifier_group_id;
        $this->isRequired = (bool) $itemModifier->is_required;
        $this->allowMultipleSelection = (bool) $itemModifier->allow_multiple_selection;
    }

    public function submitForm()
    {
        $this->validate([
            'menuItemId' => 'required',
            'modifierGroupId' => 'required|exists:modifier_groups,id|unique:item_modifiers,modifier_group_id,' . $this->itemModifierId . ',id,menu_item_id,' . $this->menuItemId,
        ], [
            'modifierGroupId.unique' => 'The selected modifier group is already associated with this menu item.',
        ]);

        $itemModifier = ItemModifier::findOrFail($this->itemModifierId);
        $itemModifier->update([
            'menu_item_id' => $this->menuItemId,
            'modifier_group_id' => $this->modifierGroupId,
            'is_required' => $this->isRequired,
            'allow_multiple_selection' => $this->allowMultipleSelection,
        ]);

        $this->dispatch('hideEditItemModifierModal');

        $this->alert('success', __('messages.itemModifierGroupUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.edit-item-modifier');
    }
}
