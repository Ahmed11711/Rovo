<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class button extends Component
{

    public mixed $target = 'submitForm';

    /**
     * Create a new component instance.
     */
    public function __construct($target = null)
    {
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button', ['target' => $this->target]);
    }

}
