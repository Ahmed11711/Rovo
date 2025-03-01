<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ItemModifier;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ItemModifiers extends Component
{
    use WithPagination, LivewireAlert;

    public $itemModifier;
    public $modifierGroupId;
    public $search = '';
    public $addItemModifierModal = false;
    public $editItemModifierModal = false;
    public $confirmDeleteModifierModal = false;

    protected $listeners = ['refreshModifierGroups' => '$refresh'];

    public function showAddItemModifierModal()
    {
        $this->addItemModifierModal = true;
    }

    public function showEditItemModifierModal($id)
    {
        $this->modifierGroupId = $id;
        $this->editItemModifierModal = true;
    }

    #[On('hideAddItemModifierModal')]
    public function hideAddItemModifierModal()
    {
        $this->addItemModifierModal = false;
    }

    #[On('hideEditItemModifierModal')]
    public function hideEditItemModifierModal()
    {
        $this->modifierGroupId = null;
        $this->editItemModifierModal = false;
    }

    public function showDeleteModifier($id)
    {
        $this->modifierGroupId = $id;
        $this->confirmDeleteModifierModal = true;
    }

    public function deleteItemModifier($id)
    {
        $itemModifier = ItemModifier::findOrFail($id);
        $itemModifier->delete();
        $this->confirmDeleteModifierModal = false;
        $this->modifierGroupId = null;
        $this->alert('success', __('messages.itemModifierGroupDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }
    public function render()
    {
        $itemModifiersQuery = ItemModifier::whereHas('menuItem', function ($query) {
            $query->where('branch_id', branch()->id);
        })->with(['menuItem', 'modifierGroup']);

        if ($this->search) {
            $itemModifiersQuery->where(function ($query) {
                $query->whereHas('menuItem', function ($query) {
                    $query->where('item_name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('modifierGroup', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        $itemModifiers = $itemModifiersQuery->paginate(10);

        return view('livewire.menu.item-modifiers', [
            'itemModifiers' => $itemModifiers
        ]);
    }
}
