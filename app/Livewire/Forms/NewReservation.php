<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\ReservationSetting;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class NewReservation extends Component
{

    use LivewireAlert;

    public $reservationSettings;
    public $date;
    public $period;
    public $numberOfGuests;
    public $slotType;
    public $specialRequest;
    public $availableTimeSlots = [];
    public $customerName;
    public $customerPhone;
    public $customerEmail;

    // Time slot options (empty until date and slot type are selected)
    public $timeSlots = [];

    public function mount()
    {
        $this->date = now(timezone())->format('d-M-Y');
        $this->slotType = 'Lunch';
        $this->numberOfGuests = 1;

        $this->loadAvailableTimeSlots();
    }

    public function setReservationGuest($noOfGuests)
    {
        $this->numberOfGuests = $noOfGuests;
    }

    public function setReservationSlotType($type)
    {
        $this->slotType = $type;
        $this->loadAvailableTimeSlots();
    }

    public function loadAvailableTimeSlots()
    {

        if ($this->date && $this->slotType) {
            $dayOfWeek = Carbon::parse($this->date)->dayOfWeek;
            $currentTime = Carbon::now(timezone())->format('H:i:s');
            $selectedDate = Carbon::parse($this->date)->format('Y-m-d');

            // Fetch available slots for the selected day of the week and slot type
            $settings = ReservationSetting::where('day_of_week', $dayOfWeek)
                ->where('slot_type', $this->slotType)
                ->where('available', 1)
                ->first();

            if ($settings) {
                // Generate time slots based on the time slot difference
                $startTime = Carbon::parse($settings->time_slot_start);
                $endTime = Carbon::parse($settings->time_slot_end);
                $slotDifference = $settings->time_slot_difference;

                $this->timeSlots = [];
                
                while ($startTime->lte($endTime)) {
                    // Check if the selected date is today and if the slot is in the past
                    if ($selectedDate == Carbon::now()->format('Y-m-d') && $startTime->format('H:i:s') <= $currentTime) {
                        $startTime->addMinutes($slotDifference);
                        continue; // Skip past times
                    }

                    $this->timeSlots[] = $startTime->format('H:i:s');
                    $startTime->addMinutes($slotDifference);
                }
            }
        }
    }

    public function submitReservation()
    {
        
        $this->validate([
            'availableTimeSlots' => 'required',
            'customerName' => 'required'
        ]);

        $existingCustomer = Customer::where('email', $this->customerEmail)->first();

        if ($existingCustomer) {
            $existingCustomer->update([
                'name' => $this->customerName,
                'phone' => $this->customerPhone
            ]);
            $customer = $existingCustomer;
        } else {
            $customer = Customer::create([
                'name' => $this->customerName,
                'phone' => $this->customerPhone,
                'email' => $this->customerEmail
            ]);
        }

        Reservation::create([
            'reservation_date_time' => $this->date . ' ' . $this->availableTimeSlots,
            'customer_id' => $customer->id,
            'party_size' => $this->numberOfGuests,
            'reservation_slot_type' => $this->slotType,
            'special_requests' => $this->specialRequest
        ]);

        $this->alert('success', __('messages.reservationConfirmed'), [
            'toast' => false,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => __('app.close')
        ]);

        return $this->redirect(route('reservations.index'));
    }
    
    public function render()
    {
        return view('livewire.forms.new-reservation');
    }

}
