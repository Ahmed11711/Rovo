<?php

namespace App\Livewire\Reservations;

use App\Models\Area;
use App\Models\Reservation;
use Livewire\Attributes\On;
use Livewire\Component;

class AssignTable extends Component
{

    public $tables;
    public $reservations;
    public $reservation;

    public function mount()
    {
        $this->tables = Area::with(['tables' => function ($query) {
            return $query->where('status', 'active');
        }])->get();

        $this->reservations = Reservation::whereDate('reservation_date_time', $this->reservation->reservation_date_time->toDateString())
            ->whereNotNull('table_id')
            ->get();
    }

    public function setReservationTable($table)
    {
        $this->reservation->update(['table_id' => $table]);
        $this->redirect(route('reservations.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.reservations.assign-table');
    }

}
