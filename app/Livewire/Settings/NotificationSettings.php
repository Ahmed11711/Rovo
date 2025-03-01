<?php

namespace App\Livewire\Settings;

use App\Models\NotificationSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class NotificationSettings extends Component
{

    use LivewireAlert;
    
    public $notificationSettings;
    public $sendEmail;

    public function mount()
    {
        $this->notificationSettings = NotificationSetting::get();
        $this->sendEmail = $this->notificationSettings->pluck('send_email')->toArray();
    }

    public function submitForm()
    {
        foreach ($this->notificationSettings as $key => $notification) {
            $notification->update(['send_email' => $this->sendEmail[$key]]);
        }

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.settings.notification-settings');
    }

}
