<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TodayTableEarnings extends Component
{

    public function render()
    {
        $orders = Order::select('table_id', DB::raw('SUM(total) as total_price'))
            ->with('table')
            ->whereNotNull('table_id')
            ->whereDate('date_time', today())
            ->groupBy('table_id')
            ->where('status', 'paid')
            ->get()->sortBy('total_price', SORT_REGULAR, true)->splice(0, 5);

        return view('livewire.dashboard.today-table-earnings', [
            'orders' => $orders
        ]);
    }

}
