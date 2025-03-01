<?php

namespace App\View\Components\order;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class orderCard extends Component
{

    public $order;

    /**
     * Create a new component instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.order.order-card');
    }

}
