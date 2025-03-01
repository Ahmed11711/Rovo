<?php

namespace App\Livewire\Restaurant;

use App\Models\Table;
use Livewire\Component;
use App\Models\Restaurant;
use Livewire\Attributes\On;
use App\Models\GlobalSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Branch;

class RestaurantList extends Component
{

    use LivewireAlert;
    public $search;
    public $count = 0;
    public $filterStatus = 'all';
    public $showAddRestaurant = false;

    public $showRegenerateQrCodes = false;

    public function mount()
    {
        $setting = GlobalSetting::first();

        $this->updatedCount();

        if (config('app.url') !== $setting->installed_url) {
            $this->showRegenerateQrCodes = true;
        }
    }

    #[On('hideAddRestaurant')]
    public function hideAddRestaurant()
    {
        $this->showAddRestaurant = false;
    }


    #[On('updatedCount')]
    public function updatedCount()
    {
        $this->count = Restaurant::where('approval_status', 'pending')->count();
    }

    public function regenerateQrCodes()
    {
        try {
            $tables = Table::all();

            foreach ($tables as $table) {
                $table->generateQrCode();
            }

            $branches = Branch::all();

            foreach ($branches as $branch) {
                $branch->generateQrCode();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $this->showRegenerateQrCodes = false;

        $setting = GlobalSetting::first();
        $setting->installed_url = config('app.url');
        $setting->saveQuietly();

        cache()->forget('global_setting');

        $this->alert('success', __('superadmin.qrCodesRegenerated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }


    public function render()
    {
        return view('livewire.restaurant.restaurant-list');
    }
}
