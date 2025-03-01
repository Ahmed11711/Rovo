<?php

namespace App\Livewire\Restaurant;

use App\Helper\Reply;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RestaurantDetail extends Component
{

    use LivewireAlert;

    public $restaurant;
    public $restaurantAdmin;
    public $showPasswordModal = false;
    public $password;
    public $hash;
    public $search;

    public function mount()
    {
        $this->restaurant = Restaurant::with('currency', 'restaurantPayment', 'restaurantPayment.package', 'restaurantPayment.package.currency')->where('hash', $this->hash)->firstOrFail();
        $this->restaurantAdmin = $this->restaurant->users->sortBy('id')->first();
    }

    public function impersonate($restaurantId)
    {
        $admin = User::where('restaurant_id', $restaurantId)->first();

        if (!$admin) {
            $this->alert('error', 'No admin found this restaurant', [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);

            return true;
        }

        $user = user();
        session()->flush();
        session()->forget('user');

        Auth::logout();
        session(['impersonate_user_id' => $user->id]);
        session(['impersonate_restaurant_id' => $restaurantId]);
        session(['user' => $admin]);

        Auth::loginUsingId($admin->id);

        session(['user' => auth()->user()]);

        return $this->redirect(route('dashboard'));
    }

    public function submitForm()
    {
        $this->validate([
            'password' => 'required'
        ]);

        $this->restaurantAdmin->password = $this->password;
        $this->restaurantAdmin->save();

        $this->alert('success', __('messages.profileUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->password = null;
        $this->showPasswordModal = false;
    }

    public function render()
    {
        return view('livewire.restaurant.restaurant-detail');
    }

}
