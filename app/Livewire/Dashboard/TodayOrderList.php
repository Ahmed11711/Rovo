<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use Livewire\Component;

class TodayOrderList extends Component
{

    public function render()
    {
        $start = now()->startOfDay()->toDateTimeString();
        $end = now()->endOfDay()->toDateTimeString();

        $orders = Order::withCount('items')->with('table')
            ->where('status', '<>', 'canceled')
            ->where('status', '<>', 'draft')
            ->orderBy('id', 'desc')
            ->whereDate('orders.date_time', '>=', $start)->whereDate('orders.date_time', '<=', $end);
            
        $orders = $orders->get();

        return view('livewire.dashboard.today-order-list', [
            'orders' => $orders
        ]);
    }

}
