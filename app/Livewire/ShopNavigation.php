<?php

namespace App\Livewire;

use Livewire\Component;

class ShopNavigation extends Component
{

    public $restaurant;
    public $shopBranch;

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
        return view('livewire.shop-navigation', ['modules' => $modules]);
    }

}
