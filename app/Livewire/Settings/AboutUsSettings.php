<?php

namespace App\Livewire\Settings;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AboutUsSettings extends Component
{
    use LivewireAlert;

    public $settings;
    public $aboutUs;
    public $trixId;

    public function mount($settings)
    {
        $this->trixId = 'trix-' . uniqid();
        $this->settings = $settings;
        $this->aboutUs = $settings->about_us;
    }

    public function submitForm()
    {
        $this->validate([
            'aboutUs' => 'required',
        ]);

        $this->settings->about_us = $this->aboutUs;
        $this->settings->save();

        $this->alert('success', __('messages.settingsUpdated'));
    }

    public function render()
    {
        return view('livewire.settings.about-us-settings');
    }
}
