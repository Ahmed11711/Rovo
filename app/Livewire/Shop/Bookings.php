<?php

namespace App\Livewire\Shop;

use App\Models\Reservation;
use Livewire\Component;

class Bookings extends Component
{

    public $bookings;

    public function mount()
    {
        if (is_null(customer()))
        {
            return $this->redirect(route('home'));
        }

        $this->bookings = Reservation::where('customer_id', customer()->id)->orderBy('id', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.shop.bookings');
    }

}
