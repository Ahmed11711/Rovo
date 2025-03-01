<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ModifierGroup;

class ModifierGroups extends Component
{
    use WithPagination;

    public $search= '';
    public $addModifierGroupModal = false;
    public $editModifierGroupModal = false;
    public $confirmDeleteModifierModal = false;
    public $modifierGroupId;

    protected $listeners = ['refreshModifierGroups' => '$refresh'];

    public function showAddModifierGroupModal()
    {
        $this->addModifierGroupModal = true;
    }

    public function showEditModifierGroupModal($id)
    {
        $this->editModifierGroupModal = true;
        $this->modifierGroupId = $id;
    }

    #[On('hideAddModifierGroupModal')]
    public function hideAddModifierGroupModal()
    {
        $this->addModifierGroupModal = false;
        $this->dispatch('refreshModifierGroups')->self();
    }
    #[On('hideEditModifierGroupModal')]
    public function hideEditModifierGroupModal()
    {
        $this->modifierGroupId = null;
        $this->editModifierGroupModal = false;
    }

    public function showDeleteModifier($id)
    {
        $this->modifierGroupId = $id;
        $this->confirmDeleteModifierModal = true;
    }

    public function deleteModifierGroup($id)
    {
        $modifierGroup = ModifierGroup::findOrFail($id);
        $modifierGroup->delete();
        $this->confirmDeleteModifierModal = false;
        $this->modifierGroupId = null;
        $this->dispatch('refreshModifierGroups')->self();
    }


    public function render()
    {

        $query = ModifierGroup::with('options');

        if (!empty($this->search)) {
            $query->where('name', 'like', "%{$this->search}%")
            ->orWhereHas('options', function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            });
        }

        $modifierGroups = $query->paginate(10);

        return view('livewire.menu.modifier-groups', compact('modifierGroups'));
    }

}
