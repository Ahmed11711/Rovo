<?php

namespace App\Livewire\Settings;

use App\Models\PusherSetting;
use App\Models\PusherSettings;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PushNotificationSettings extends Component
{

    use LivewireAlert;

    public $beamerStatus = false;
    public $instanceID;
    public $beamSecret;
    public $pusherSettings;

    public function mount()
    {
        $this->pusherSettings = PusherSetting::first();
        $this->beamerStatus = (bool)$this->pusherSettings->beamer_status;
        $this->instanceID = $this->pusherSettings->instance_id;
        $this->beamSecret = $this->pusherSettings->beam_secret;
    }

    public function submitForm()
    {
        $this->validate([
            'instanceID' => 'required_if:beamerStatus,true',
            'beamSecret' => 'required_if:beamerStatus,true'
        ]);

        $this->pusherSettings->update([
            'beamer_status' => $this->beamerStatus,
            'instance_id' => $this->instanceID,
            'beam_secret' => $this->beamSecret
        ]);

        $this->pusherSettings->fresh();     

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    
    }
    public function render()
    {
        return view('livewire.settings.push-notification-settings');
    }
}
