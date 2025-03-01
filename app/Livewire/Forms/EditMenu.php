<?php

namespace App\Livewire\Forms;

use App\Models\Menu;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditMenu extends Component
{
    use LivewireAlert;
    
    public $menuName;
    public $activeMenu;
   
    public function mount()
    {
        $this->menuName = $this->activeMenu->menu_name;
    }

    public function submitForm()
    {
        $this->validate([
            'menuName' => 'required'
        ]);

        Menu::where('id', $this->activeMenu->id)->update([
            'menu_name' => $this->menuName
        ]);

        // Reset the value
        $this->menuName = '';

        $this->dispatch('refreshMenus');
        $this->dispatch('hideEditMenu');

        $this->alert('success', __('messages.menuUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }
    
    public function render()
    {
        return view('livewire.forms.edit-menu');
    }

}
