<?php

namespace App\Livewire\SuperadminSettings;

use App\Models\GlobalSetting;
use Livewire\Attributes\On;
use Livewire\Component;

class Master extends Component
{

    public $settings;
    public $activeSetting;

    public function mount()
    {
        $this->settings = GlobalSetting::first();
        $this->activeSetting = request('tab') != '' ? request('tab') : 'app';
    }

    #[On('settingsUpdated')]
    public function refreshSettings()
    {
        session()->forget(['global_setting', 'restaurantOrGlobalSetting']);

        $this->settings->fresh();
    }

    public function render()
    {
        return view('livewire.superadmin-settings.master');
    }
}
