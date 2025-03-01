<?php

namespace App\Livewire;

use Livewire\Component;

class SidebarDropdownMenu extends Component
{

    public $name;
    public $link;
    public $active = false;
    
    public function render()
    {
        return view('livewire.sidebar-dropdown-menu');
    }

}
