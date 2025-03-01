<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AverageDailyEarning extends Component
{

    public $orderCount;
    public $percentChange;
    
    public function mount()
    {
        $currentMonth = now()->format('Y-m');
        $daysInMonth = now()->format('d');

        $previousMonth = now()->subMonth()->format('Y-m');
        $daysInPreviousMonth = now()->subMonth()->daysInMonth;
    
        $totalEarnings = Order::where('status', 'paid')
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $currentMonth)
            ->sum('total');

        $totalPreviousEarnings = Order::where('status', 'paid')
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $previousMonth)
            ->sum('total');
    
        $this->orderCount = ($totalEarnings / $daysInMonth);

        $averageDailyPreviousEarnings = $totalPreviousEarnings / $daysInPreviousMonth;

        $orderDifference = ($this->orderCount - $averageDailyPreviousEarnings);

        $this->percentChange  = (($orderDifference / ($averageDailyPreviousEarnings == 0 ? 1 : $averageDailyPreviousEarnings)) * 100);
    }

    public function render()
    {
        return view('livewire.dashboard.average-daily-earning');
    }

}
