<?php

namespace App\Livewire\Forms;

use App\Models\Menu;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddMenu extends Component
{
    use LivewireAlert;
    
    public $menuName;

    public function mount()
    {
        $this->menuName = '';
    }

    public function submitForm()
    {
        $this->validate([
            'menuName' => 'required'
        ]);

        Menu::create([
            'menu_name' => $this->menuName
        ]);

        // Reset the value
        $this->menuName = '';

        $this->dispatch('refreshMenus');
        $this->dispatch('menuAdded');

        $this->alert('success', __('messages.menuAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.add-menu');
    }

}
