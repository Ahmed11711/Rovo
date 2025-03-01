<?php

namespace App\Livewire;

use App\Models\Customer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UpdateProfile extends Component
{
    use LivewireAlert;

    public $fullName;
    public $email;
    public $phone;
    public $address;

    public function mount()
    {
        if (is_null(customer()))
        {
            return $this->redirect(route('home'));
        }
        
        $this->fullName = customer()->name;
        $this->email = customer()->email;
        $this->phone = customer()->phone;
        $this->address = customer()->delivery_address;
    }

    public function submitForm()
    {
        $this->validate([
            'fullName' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $customer = Customer::findOrFail(customer()->id);
        $customer->name = $this->fullName;
        $customer->phone = $this->phone;
        $customer->delivery_address = $this->address;
        $customer->save();

        session(['customer' => $customer]);
        $this->dispatch('setCustomer', customer: $customer);

        $this->alert('success', __('messages.profileUpdated'), [
            'position' => 'center'
        ]);

    }

    public function render()
    {
        return view('livewire.update-profile');
    }

}
