<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\RestaurantSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RestaurantSettings extends Component
{
    use LivewireAlert;

    public $restaurantSettings;
    public bool $requiresApproval;

    public function mount()
    {
        $this->restaurantSettings = RestaurantSetting::first();
        $this->requiresApproval = $this->restaurantSettings->requires_approval_after_signup;
    }

    public function submitForm()
    {
        $this->validate([
            'requiresApproval' => 'required|boolean',
        ]);

        $this->restaurantSettings->update([
            'requires_approval_after_signup' => $this->requiresApproval,
        ]);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.settings.restaurant-settings');
    }
}
