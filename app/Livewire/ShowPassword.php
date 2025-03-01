<?php

namespace App\Livewire;

use Livewire\Component;

class ShowPassword extends Component
{
    public $password = '';
    public $isVisible = false;

    public function toggleVisibility()
    {
        $this->isVisible = !$this->isVisible;
    }

    public function render()
    {
        return view('components.input-password');
    }
}
