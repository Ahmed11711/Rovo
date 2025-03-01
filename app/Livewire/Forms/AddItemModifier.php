<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\MenuItem;
use App\Models\ItemModifier;
use App\Models\ModifierGroup;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddItemModifier extends Component
{
    use LivewireAlert;

    public $menuItemId;
    public $modifierGroupId;
    public $isRequired = false;
    public $allowMultipleSelection = false;
    public $showAddModifierGroupModal = false;

    public function submitForm()
    {
        $this->validate([
            'menuItemId' => 'required',
            'modifierGroupId' => 'required|exists:modifier_groups,id|unique:item_modifiers,modifier_group_id,NULL,id,menu_item_id,' . $this->menuItemId,
        ], [
            'modifierGroupId.unique' => 'The selected modifier group is already associated with this menu item.',
        ]);

        ItemModifier::create([
            'menu_item_id' => $this->menuItemId,
            'modifier_group_id' => $this->modifierGroupId,
            'is_required' => $this->isRequired,
            'allow_multiple_selection' => $this->allowMultipleSelection,
        ]);


        $this->dispatch('hideAddItemModifierModal');
        $this->resetForm();

        $this->alert('success', __('messages.itemModifierGroupAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'menuItemId',
            'modifierGroupId',
            'isRequired',
            'allowMultipleSelection',
            'showAddModifierGroupModal',
        ]);
    }

    // #[On('hideAddModifierGroupModal')]
    // public function hideAddModifierGroupModal()
    // {
    //     $this->resetForm();
    // }

    public function render()
    {
        return view('livewire.forms.add-item-modifier', [
            'menuItems' => MenuItem::select('id', 'item_name')->get(),
            'modifierGroups' => ModifierGroup::select('id', 'name')->get(),
        ]);
    }
}
