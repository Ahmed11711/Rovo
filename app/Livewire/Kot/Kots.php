<?php

namespace App\Livewire\Kot;

use App\Models\Kot;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Kots extends Component
{

    protected $listeners = ['refreshKots' => '$refresh'];
    public $filterOrders;
    public $dateRangeType;
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->dateRangeType = 'today';
        $this->filterOrders = 'in_kitchen';
        $this->startDate = now()->startOfWeek()->format('m/d/Y');
        $this->endDate = now()->endOfWeek()->format('m/d/Y');

        $this->setDateRange();
    }

    public function setDateRange()
    {
        switch ($this->dateRangeType) {
        case 'today':
            $this->startDate = now()->startOfDay()->format('m/d/Y');
            $this->endDate = now()->startOfDay()->format('m/d/Y');
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

    public function render()
    {
        $start = Carbon::createFromFormat('m/d/Y', $this->startDate)->startOfDay()->toDateTimeString();
        $end = Carbon::createFromFormat('m/d/Y', $this->endDate)->endOfDay()->toDateTimeString();
        
        $kots = Kot::withCount('items')->orderBy('id', 'desc')
            ->join('orders', 'kots.order_id', '=', 'orders.id')
            ->whereDate('kots.created_at', '>=', $start)->whereDate('kots.created_at', '<=', $end)
            ->where('orders.status', '<>', 'canceled')
            ->where('orders.status', '<>', 'draft')
            ->get();

        $inKitchen = $kots->filter(function ($order) {
            return $order->status == 'in_kitchen';
        });

        $served = $kots->filter(function ($order) {
            return $order->status == 'served';
        });

        $foodReady = $kots->filter(function ($order) {
            return $order->status == 'food_ready';
        });

        switch ($this->filterOrders) {
        case 'in_kitchen':
            $kotList = $inKitchen;
                break;

        case 'served':
            $kotList = $served;
                break;
            
        case 'food_ready':
            $kotList = $foodReady;
                break;
            
        default:
            $kotList = $kots;
                break;
        }

        return view('livewire.kot.kots', [
            'kots' => $kotList,
            'inKitchenCount' => count($inKitchen),
            'servedCount' => count($served),
            'foodReadyCount' => count($foodReady),
        ]);
    }

}
