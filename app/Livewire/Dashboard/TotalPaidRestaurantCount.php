<?php

namespace App\Livewire\Dashboard;

use App\Models\Restaurant;
use Livewire\Component;

class TotalPaidRestaurantCount extends Component
{

    public $orderCount;
    public $percentChange;
    
    public function mount()
    {
        $this->orderCount = Restaurant::where('license_type', 'paid')->count();
    }

    public function render()
    {
        return view('livewire.dashboard.total-paid-restaurant-count');
    }

}
