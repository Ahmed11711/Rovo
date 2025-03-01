<?php

namespace App\Livewire\Forms;

use App\Models\ItemCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditItemCategory extends Component
{
    use LivewireAlert;
    
    public $categoryName;
    public $itemCategory;

    public function mount()
    {
        $this->categoryName = $this->itemCategory->category_name;
    }

    public function submitForm()
    {
        $this->validate([
            'categoryName' => 'required|unique:item_categories,category_name,'.$this->itemCategory->id.',id,branch_id,' . branch()->id,
        ]);

        ItemCategory::where('id', $this->itemCategory->id)->update([
            'category_name' => $this->categoryName
        ]);

        // Reset the value
        $this->categoryName = '';

        $this->dispatch('refreshCategories');
        $this->dispatch('hideCategoryModal');

        $this->alert('success', __('messages.categoryUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.edit-item-category');
    }

}
