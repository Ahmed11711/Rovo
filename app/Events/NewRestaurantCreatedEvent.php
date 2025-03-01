<?php

namespace App\Events;

use App\Models\Restaurant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRestaurantCreatedEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $restaurant;

    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }
}
