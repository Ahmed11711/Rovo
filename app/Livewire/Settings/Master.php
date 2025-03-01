<?php

namespace App\Livewire\Settings;

use App\Models\Restaurant;
use Livewire\Attributes\On;
use Livewire\Component;

class Master extends Component
{

    public $settings;
    public $activeSetting;

    public function mount()
    {
        $this->settings = Restaurant::find(restaurant()->id);
        $this->activeSetting = request('tab') != '' ? request('tab') : (user()->hasRole('Admin_'.user()->restaurant_id) ? 'restaurant' : 'reservation');
    }

    #[On('settingsUpdated')]
    public function refreshSettings()
    {
        session()->forget(['restaurant', 'timezone', 'currency']);

        $this->settings->fresh();
    }

    public function render()
    {
        return view('livewire.settings.master');
    }

}
