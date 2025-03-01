<?php

namespace App\Livewire\Shop;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{

    public $orders;
    public $restaurant;

    public function mount()
    {
        if (is_null(customer()))
        {
            return $this->redirect(route('home'));
        }

        $this->orders = Order::withoutGlobalScopes()->where('customer_id', customer()->id)->orderBy('id', 'desc')
            ->where('status', '<>', 'canceled')
            ->where('status', '<>', 'draft')
            ->get();
    }

    public function render()
    {
        return view('livewire.shop.orders');
    }

}
