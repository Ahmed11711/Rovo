<?php

namespace App\Livewire\Forms;

use App\Models\ItemCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddItemCategory extends Component
{
    use LivewireAlert;
    
    public $categoryName;

    public function mount()
    {
        $this->categoryName = '';
    }

    public function submitForm()
    {
        $this->validate([
            'categoryName' => 'required|unique:item_categories,category_name,null,id,branch_id,' . branch()->id,
        ]);

        ItemCategory::create([
            'category_name' => $this->categoryName
        ]);

        // Reset the value
        $this->categoryName = '';

        $this->dispatch('refreshCategories');
        $this->dispatch('hideCategoryModal');

        $this->alert('success', __('messages.categoryAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.add-item-category');
    }

}
