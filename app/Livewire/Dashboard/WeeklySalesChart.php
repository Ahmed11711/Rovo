<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WeeklySalesChart extends Component
{

    public function render()
    {
        $startOfMonth = now()->startOfMonth()->startOfDay()->toDateTimeString();
        $tillToday = now()->endOfDay()->toDateTimeString();

        $startOfLastMonth = now()->subMonth()->startOfMonth()->startOfDay()->toDateTimeString();
        $endOfLastMonth = now()->subMonth()->endOfMonth()->endOfDay()->toDateTimeString();

        $salesData = Order::select(
            DB::raw('DATE(date_time) as date'),
            DB::raw('SUM(total) as total_sales')
        )
            ->whereDate('orders.date_time', '>=', $startOfMonth)->whereDate('orders.date_time', '<=', $tillToday)
            ->where('status', 'paid')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $monthlyEarnings = Order::whereDate('orders.date_time', '>=', $startOfMonth)->whereDate('orders.date_time', '<=', $tillToday)
            ->where('status', 'paid')
            ->sum('total');

        $previousEarnings = Order::whereDate('orders.date_time', '>=', $startOfLastMonth)->whereDate('orders.date_time', '<=', $endOfLastMonth)
            ->where('status', 'paid')
            ->sum('total');

        $orderDifference = ($monthlyEarnings - $previousEarnings);

        $percentChange  = (($orderDifference / ($previousEarnings == 0 ? 1 : $previousEarnings)) * 100);
        
        return view('livewire.dashboard.weekly-sales-chart', [
            'salesData' => $salesData,
            'monthlyEarnings' => $monthlyEarnings,
            'percentChange' => $percentChange,
        ]);
    }

}
