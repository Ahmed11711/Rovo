<?php

namespace App\Livewire\Reports;

use App\Exports\SalesReportExport;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SalesReport extends Component
{

    public $dateRangeType;
    public $startDate;
    public $endDate;

    public function mount()
    {
        abort_if(!in_array('Report', restaurant_modules()), 403);
        abort_if((!user_can('Show Reports')), 403);

        $this->dateRangeType = 'currentWeek';
        $this->startDate = now()->startOfWeek()->format('m/d/Y');
        $this->endDate = now()->endOfWeek()->format('m/d/Y');
    }

    public function setDateRange()
    {
        switch ($this->dateRangeType) {
            case 'today':
                $this->startDate = now()->startOfDay()->format('m/d/Y');
                $this->endDate = now()->endOfDay()->format('m/d/Y');
                break;

            case 'lastWeek':
                $this->startDate = now()->subWeek()->startOfWeek()->format('m/d/Y');
                $this->endDate = now()->subWeek()->endOfWeek()->format('m/d/Y');
                break;

            case 'last7Days':
                $this->startDate = now()->subDays(7)->format('m/d/Y');
                $this->endDate = now()->startOfDay()->format('m/d/Y');
                break;

            case 'currentMonth':
                $this->startDate = now()->startOfMonth()->format('m/d/Y');
                $this->endDate = now()->startOfDay()->format('m/d/Y');
                break;

            case 'lastMonth':
                $this->startDate = now()->subMonth()->startOfMonth()->format('m/d/Y');
                $this->endDate = now()->subMonth()->endOfMonth()->format('m/d/Y');
                break;

            case 'currentYear':
                $this->startDate = now()->startOfYear()->format('m/d/Y');
                $this->endDate = now()->startOfDay()->format('m/d/Y');
                break;

            case 'lastYear':
                $this->startDate = now()->subYear()->startOfYear()->format('m/d/Y');
                $this->endDate = now()->subYear()->endOfYear()->format('m/d/Y');
                break;

            default:
                $this->startDate = now()->startOfWeek()->format('m/d/Y');
                $this->endDate = now()->endOfWeek()->format('m/d/Y');
                break;
        }
    }

    #[On('setStartDate')]
    public function setStartDate($start)
    {
        $this->startDate = $start;
    }

    #[On('setEndDate')]
    public function setEndDate($end)
    {
        $this->endDate = $end;
    }

    public function exportReport()
    {
        if (!in_array('Export Report', restaurant_modules())) {
            $this->dispatch('showUpgradeLicense');
        } else {
            return Excel::download(new SalesReportExport($this->startDate, $this->endDate), 'sales-report-' . now()->toDateTimeString() . '.xlsx');
        }
    }

    public function render()
    {
        $start = Carbon::createFromFormat('m/d/Y', $this->startDate)->startOfDay()->toDateTimeString();
        $end = Carbon::createFromFormat('m/d/Y', $this->endDate)->endOfDay()->toDateTimeString();

        $query = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->whereDate('orders.date_time', '>=', $start)
            ->whereDate('orders.date_time', '<=', $end)
            ->select(
                DB::raw('DATE(orders.date_time) as date'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(order_items.amount) as total_amount'),
                DB::raw('payments.payment_method'),
                DB::raw('SUM(CASE WHEN payments.payment_method = "cash" THEN order_items.amount ELSE 0 END) as cash_amount'),
                DB::raw('SUM(CASE WHEN payments.payment_method = "card" THEN order_items.amount ELSE 0 END) as card_amount'),
                DB::raw('SUM(CASE WHEN payments.payment_method = "upi" THEN order_items.amount ELSE 0 END) as upi_amount'),
                DB::raw('SUM(CASE WHEN payments.payment_method NOT IN ("cash", "card", "upi") THEN order_items.amount ELSE 0 END) as other_amount')
            )
            ->groupBy('date', 'payments.payment_method')
            ->orderBy('date')
            ->where('orders.status', 'paid')
            ->get();

        // Group by date to combine payment methods
        $groupedData = $query->groupBy('date')->map(function ($items) {
            return [
                'date' => $items[0]->date,
                'total_orders' => $items[0]->total_orders,
                'total_amount' => $items->sum('total_amount'),
                'cash_amount' => $items->sum('cash_amount'),
                'card_amount' => $items->sum('card_amount'),
                'upi_amount' => $items->sum('upi_amount'),
                'other_amount' => $items->sum('other_amount')
            ];
        })->values();

        return view('livewire.reports.sales-report', [
            'menuItems' => $groupedData
        ]);
    }
}
