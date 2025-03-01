<?php

namespace App\Livewire\Dashboard;

use App\Models\Restaurant;
use Livewire\Component;

class TotalFreeRestaurantCount extends Component
{

    public $orderCount;
    public $percentChange;
    
    public function mount()
    {
        $this->orderCount = Restaurant::where('license_type', 'free')->count();
    }
    
    public function render()
    {
        return view('livewire.dashboard.total-free-restaurant-count');
    }

}
