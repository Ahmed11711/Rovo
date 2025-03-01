<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{

    protected function hasModule($module)
    {
        return in_array($module, restaurant_modules());
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
