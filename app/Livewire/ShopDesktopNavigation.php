<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class ShopDesktopNavigation extends Component
{
    protected $listeners = ['setCustomer' => '$refresh'];

    public $orderItemCount = 0;
    public $restaurant;
    public $shopBranch;

    #[On('updateCartCount')]
    public function updateCartCount($count)
    {
        $this->orderItemCount = $count;
    }

    public function getShouldShowWaiterButtonProperty()
    {
        $this->dispatch('refreshComponent');

        if (!$this->restaurant->is_waiter_request_enabled) {
            return false;
        }

        $isDesktop = true;
        $cameFromQR = request()->query('from_qr') == 1;

        if ($isDesktop && !$this->restaurant->is_waiter_request_enabled_on_desktop) {
            return false;
        }

        if (!$isDesktop && !$this->restaurant->is_waiter_request_enabled_on_mobile) {
            return false;
        }

        if ($cameFromQR && !$this->restaurant->is_waiter_request_enabled_open_by_qr) {
            return false;
        }

        return true;
    }

    private function getPackageModules($restaurant)
    {
        if (!$restaurant || !$restaurant->package) {
            return [];
        }

        $modules = $restaurant->package->modules->pluck('name')->toArray();
        $additionalFeatures = json_decode($restaurant->package->additional_features ?? '[]', true);

        return array_merge($modules, $additionalFeatures);
    }

    public function render()
    {
        $modules = $this->getPackageModules($this->restaurant);

        return view('livewire.shop-desktop-navigation', ['modules' => $modules]);
    }

}
