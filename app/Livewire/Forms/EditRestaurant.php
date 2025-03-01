<?php

namespace App\Livewire\Forms;

use App\Models\Country;
use App\Models\Restaurant;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditRestaurant extends Component
{

    use LivewireAlert;

    public $restaurantName;
    public $fullName;
    public $email;
    public $phone;
    public $address;
    public $country;
    public $facebook;
    public $instagram;
    public $twitter;
    public $countries;
    public $restaurant;
    public $status;
    public $sub_domain;
    public $domain;


    public function mount()
    {
        if (module_enabled('Subdomain')) {
            $this->sub_domain = str_replace('.' . getDomain(), '', $this->restaurant->sub_domain);
            $this->domain = str($this->restaurant->sub_domain)->endsWith(getDomain()) ? '.' . getDomain() : '';
        }

        $this->countries = Country::all();

        $this->restaurantName = $this->restaurant->name;
        $this->email = $this->restaurant->email;
        $this->phone = $this->restaurant->phone_number;
        $this->address = $this->restaurant->address;
        $this->country = $this->restaurant->country_id;
        $this->facebook = $this->restaurant->facebook_link;
        $this->instagram = $this->restaurant->instagram_link;
        $this->twitter = $this->restaurant->twitter_link;
        $this->status = $this->restaurant->is_active;
    }

    public function submitForm()
    {

        $this->validate([
            'restaurantName' => 'required',
            'email' => 'required',
        ]);

        if (module_enabled('Subdomain')) {

            $this->validate([
                'sub_domain' => 'regex:/^[a-z0-9-_]{2,20}$/|required|banned_sub_domain|min:3|max:50',
            ]);

            $restaurant = Restaurant::where('id', '!=', $this->restaurant->id)
                ->where('sub_domain', strtolower($this->sub_domain . $this->domain))
                ->exists();

            if ($restaurant) {
                $this->addError('sub_domain', __('subdomain::app.messages.subdomainAlreadyExists'));
                return;
            }

            $this->restaurant->sub_domain = strtolower($this->sub_domain . $this->domain);
        }

        $this->restaurant->name = $this->restaurantName;
        $this->restaurant->address = $this->address;
        $this->restaurant->email = $this->email;
        $this->restaurant->phone_number = $this->phone;
        $this->restaurant->country_id = $this->country;
        $this->restaurant->facebook_link = $this->facebook;
        $this->restaurant->instagram_link = $this->instagram;
        $this->restaurant->twitter_link = $this->twitter;

        $this->restaurant->is_active = (bool)$this->status;
        $this->restaurant->save();

        $this->dispatch('hideEditStaff');

        $this->alert('success', __('messages.restaurantUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.edit-restaurant');
    }
}
