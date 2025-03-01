<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\MenuItem;
use App\Models\MenuItemVariation;

class ItemModifiers extends Component
{
    public $selectedModifierItem;
    public $menuItemId;
    public $selectedModifiers = [];
    public $finalModifiers = [];
    public $modifiers = [];
    public $requiredModifiers = [];
    public $selectedVariationName;

    public function mount()
    {

        $this->selectedModifierItem = MenuItem::with(['modifierGroups', 'modifierGroups.options'])
            ->findOrFail($this->menuItemId);

        if (strpos($this->menuItemId, '_') !== false) {
            [$this->menuItemId, $variationId] = explode('_', $this->menuItemId);
            $menuItemVariation = MenuItemVariation::find($variationId);
            $this->selectedVariationName = $menuItemVariation->variation ?? null;
        }

        $this->modifiers = $this->selectedModifierItem->modifierGroups;

    }

    public function toggleSelection($groupId, $optionId)
    {
        $modifierGroup = $this->selectedModifierItem->modifierGroups()
            ->withPivot(['is_required', 'allow_multiple_selection'])
            ->firstWhere('modifier_groups.id', $groupId);

        $allowMultiple = $modifierGroup->pivot->allow_multiple_selection;

        if ($allowMultiple) {
            if (in_array($optionId, $this->selectedModifiers)) {
                if ($optionId !== 1) {
                    $this->selectedModifiers = array_diff($this->selectedModifiers, [$optionId]);
                }
            }
        } else {
            if (isset($this->selectedModifiers[$optionId]) && $this->selectedModifiers[$optionId]) {
                foreach ($modifierGroup->options as $option) {
                    if ($option->id != $optionId) {
                        unset($this->selectedModifiers[$option->id]);
                    }
                }
            }
        }
    }

    public function saveModifiers()
    {
        $this->validateRequiredModifiers();

        $this->finalModifiers = [
            $this->menuItemId => array_keys(array_filter($this->selectedModifiers))
        ];

        $this->dispatch('setPosModifier', $this->finalModifiers);
    }

    public function validateRequiredModifiers()
    {
        $rules = [];
        $messages = [];

        $modifierGroups = $this->selectedModifierItem->modifierGroups()
            ->withPivot(['is_required'])
            ->get();

        foreach ($modifierGroups as $modifierGroup) {
            if ($modifierGroup->pivot->is_required) {
                $selectedOptions = array_keys(array_filter($this->selectedModifiers, function ($selected, $optionId) use ($modifierGroup) {
                    return $selected && $modifierGroup->options->contains('id', $optionId);
                }, ARRAY_FILTER_USE_BOTH));

                if (empty($selectedOptions)) {
                    $rules["requiredModifiers.{$modifierGroup->id}"] = 'required';
                    $messages["requiredModifiers.{$modifierGroup->id}.required"] = "This modifier group is required and you must select at least one option.";
                }
            }
        }

        if (!empty($rules)) {
            $this->validate($rules, $messages);
        }
    }

    public function render()
    {
        return view('livewire.pos.item-modifiers');
    }
}
