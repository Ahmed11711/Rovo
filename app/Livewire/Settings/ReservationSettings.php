<?php

namespace App\Livewire\Settings;

use App\Models\ReservationSetting;
use Livewire\Component;

class ReservationSettings extends Component
{

    public $activeMenu;
    public $weekDay = null;
    public $menuItems = false;

    public function mount()
    {
        $this->showItems('Monday');
    }

    public function showItems($day)
    {
        $this->weekDay = $day;
        $this->menuItems = true;
    }

    public function render()
    {

        $reservationSettings = ReservationSetting::select('day_of_week')
            ->distinct()
            ->orderBy('day_of_week')
            ->get();

        return view('livewire.settings.reservation-settings', [
            'reservationSettings' => $reservationSettings
        ]);
    }

}
