<?php

namespace App\Livewire\Menu;

use Livewire\Attributes\On;
use Livewire\Component;

class MenuItemsContent extends Component
{
    public $showAddMenuItem = false;
    public $showFilterButton = true;
    public $search = '';

    #[On('hideAddMenuItem')]
    public function hideAddMenuItem()
    {
        $this->showAddMenuItem = false;
    }

    #[On('clearMenuItemFilter')]
    public function clearMenuItemFilter()
    {
        $this->showFilterButton = false;
        $this->search = '';
    }

    #[On('hideMenuItemFilters')]
    public function hideMenuItemFiltersBtn()
    {
        $this->showFilterButton = true;
    }

    public function render()
    {
        return view('livewire.menu.menu-items-content');
    }

}
