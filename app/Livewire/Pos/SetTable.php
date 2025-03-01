<?php

namespace App\Livewire\Pos;

use App\Models\Area;
use App\Models\Reservation;
use Livewire\Attributes\On;
use Livewire\Component;

class SetTable extends Component
{

    public $tables;
    public $reservations;

    public function mount()
    {
        $this->tables = Area::with(['tables' => function ($query) {
            return $query->where('available_status', '<>', 'running')->where('status', 'active');
        }])->get();

        $this->reservations = Reservation::whereDate('reservation_date_time', now(timezone())->toDateString())
            ->whereNotNull('table_id')
            ->get();
    }

    #[On('posOrderSuccess')]
    public function posOrderSuccess()
    {
        $this->tables = Area::with(['tables' => function ($query) {
            return $query->where('available_status', '<>', 'running')->where('status', 'active');
        }])->get();
    }

    public function setOrderTable($table)
    {
        $this->dispatch('setTable', table: $table);
    }

    public function render()
    {
        return view('livewire.pos.set-table');
    }

}
