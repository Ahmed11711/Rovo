<?php

namespace App\Livewire\Dashboard;

use App\Models\Reservation;
use Livewire\Component;

class TodayReservations extends Component
{

    public function render()
    {
        return view('livewire.dashboard.today-reservations', [
            'count' => Reservation::whereDate('reservation_date_time', '>=', now(timezone())->startOfDay()->toDateTimeString())
            ->whereDate('reservation_date_time', '<=', now(timezone())->endOfDay()->toDateTimeString())
            ->where('reservation_status', 'Confirmed')
            ->whereNull('table_id')
            ->count()
        ]);
    }

}
