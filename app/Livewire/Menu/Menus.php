<?php

namespace App\Livewire\Menu;

use App\Models\Menu;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Menus extends Component
{
    use LivewireAlert;

    protected $listeners = ['refreshMenus' => 'mount'];

    public $activeMenu;
    public $search = '';
    public $menuId = null;
    public $menuItems = false;
    public $showEditMenuModal = false;
    public $confirmDeleteMenuModal = false;

    public function mount()
    {
        $firstMenu = Menu::first();

        if ($firstMenu) {
            $this->showMenuItems($firstMenu->id);
        }
    }

    public function showMenuItems($id)
    {
        $this->activeMenu = Menu::findOrFail($id);
        $this->menuId = $id;
        $this->menuItems = true;
    }

    public function showEditMenu($id)
    {
        $this->showEditMenuModal = true;
        $this->activeMenu = Menu::findOrFail($id);
    }

    #[On('hideEditMenu')]
    public function hideEditMenu()
    {
        $this->showEditMenuModal = false;
    }

    public function deleteMenu($id)
    {
        Menu::destroy($id);
        $this->confirmDeleteMenuModal = false;

        $this->alert('success', __('messages.menuDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->menuItems = false;
        $this->activeMenu = false;
    }

    public function render()
    {
        return view('livewire.menu.menus', [
            'menus' => Menu::withCount('items')->search('menu_name', $this->search)->get()
        ]);
    }

}
