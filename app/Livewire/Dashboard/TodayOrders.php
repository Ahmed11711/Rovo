<?php

namespace App\Livewire\Dashboard;

use App\Models\Kot;
use App\Models\Order;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TodayOrders extends Component
{

    use LivewireAlert;

    public function render()
    {
        $count = Order::whereDate('orders.date_time', '>=', now()->startOfDay()->toDateTimeString())
        ->whereDate('orders.date_time', '<=', now()->endOfDay()->toDateTimeString())
        ->where('status', '<>', 'canceled')
        ->where('status', '<>', 'draft')
        ->count();

        $todayKotCount = Kot::join('orders', 'kots.order_id', '=', 'orders.id')
        ->whereDate('kots.created_at', '>=', now()->startOfDay()->toDateTimeString())
        ->whereDate('kots.created_at', '<=', now()->endOfDay()->toDateTimeString())
        ->where('orders.status', '<>', 'canceled')
        ->where('orders.status', '<>', 'draft')
        ->count();

        $playSound = false;

        if (session()->has('today_order_count') && session('today_order_count') < $todayKotCount) {
            $playSound = true;
            
            $this->alert('success', __('messages.newOrderReceived'), [
                'toast' => true,
                'position' => 'top-end'
            ]);

        }

        session(['today_order_count' => $todayKotCount]);

        return view('livewire.dashboard.today-orders', [
            'count' => $count,
            'playSound' => $playSound
        ]);
    }

}
