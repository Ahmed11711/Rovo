<?php

namespace App\View\Components\kot;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class kotCard extends Component
{
    public $kot;

    /**
     * Create a new component instance.
     */
    public function __construct($kot)
    {
        $this->kot = $kot;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kot.kot-card');
    }

}
