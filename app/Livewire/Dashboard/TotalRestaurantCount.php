<?php

namespace App\Livewire\Dashboard;

use App\Models\Restaurant;
use Livewire\Component;

class TotalRestaurantCount extends Component
{

    public $orderCount;
    public $percentChange;
    
    public function mount()
    {
        $this->orderCount = Restaurant::count();
    }
    
    public function render()
    {
        return view('livewire.dashboard.total-restaurant-count');
    }

}
