<?php

namespace App\Livewire\Reservations;

use App\Models\Reservation;
use Livewire\Component;

class ReservationCard extends Component
{
    public $reservation;
    public $tableReservation;
    public $showTableModal = false;
    public $reservationStatus;

    public function mount()
    {
        $this->reservationStatus = $this->reservation->reservation_status;
    }

    public function assignTable($reservationId)
    {
        $this->tableReservation = Reservation::find($reservationId);
        $this->showTableModal = true;
    }
    
    public function setReservationStatus($status)
    {
        $this->reservation->update(['reservation_status' => $status]);

        if ($status == 'Cancelled') {
            $this->reservation->table->update(['available_status' => 'available']);
            $this->reservation->update(['table_id' => null]);
        }

        $this->redirect(route('reservations.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.reservations.reservation-card');
    }

}
