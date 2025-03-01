<?php

namespace App\Livewire\Shop;

use App\Events\ReservationReceived;
use App\Models\Branch;
use App\Models\Reservation;
use App\Models\ReservationSetting;
use App\Notifications\ReservationConfirmation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BookATable extends Component
{

    use LivewireAlert;

    protected $listeners = ['setCustomer' => '$refresh'];

    public $reservationSettings;
    public $date;
    public $period;
    public $numberOfGuests;
    public $slotType;
    public $specialRequest;
    public $restaurant;
    public $availableTimeSlots = [];
    public $shopBranch;

    // Time slot options (empty until date and slot type are selected)
    public $timeSlots = [];

    public function mount()
    {
        if (!$this->restaurant)
        {
            return $this->redirect(route('home'));
        }

        $startOfWeek = now()->timezone(timezone());
        $endOfWeek = now()->timezone(timezone())->addDays(6);

        $period = CarbonPeriod::create($startOfWeek, $endOfWeek); // Create a period for the week

        $this->date = $period->copy()->first()->format('Y-m-d');

        $hour = now()->timezone(timezone())->format('H');
        $dayTerm = (intval($hour) >= 17) ? 'Dinner' : ((intval($hour) >= 12) ? 'Lunch' : 'Breakfast');

        $this->slotType = $dayTerm;
        $this->numberOfGuests = 1;

        if (request()->branch && request()->branch != '') {
            $this->shopBranch = Branch::find(request()->branch);

        } else {
            $this->shopBranch = $this->restaurant->branches->first();
        }

        $this->loadAvailableTimeSlots();
    }

    public function setReservationDate($selectedDate)
    {
        $this->date = $selectedDate;
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
            $dayOfWeek = Carbon::parse($this->date)->format('l');
            $currentTime = Carbon::now(timezone())->format('H:i:s');
            $selectedDate = Carbon::parse($this->date)->format('Y-m-d');

            // Fetch available slots for the selected day of the week and slot type
            $settings = ReservationSetting::where('day_of_week', $dayOfWeek)
                ->where('slot_type', $this->slotType)
                ->where('available', 1)
                ->where('branch_id', $this->shopBranch->id)
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
        ]);

        $defaultTableReservationStatus = $this->restaurant->default_table_reservation_status;

        $reservation = Reservation::create([
            'reservation_date_time' => $this->date . ' ' . $this->availableTimeSlots,
            'customer_id' => customer()->id,
            'branch_id' => $this->shopBranch->id,
            'party_size' => $this->numberOfGuests,
            'reservation_slot_type' => $this->slotType,
            'reservation_status' => $defaultTableReservationStatus,
            'special_requests' => $this->specialRequest
        ]);


        customer()->notify(new ReservationConfirmation($reservation));

        ReservationReceived::dispatch($reservation);

        $this->alert('success', __('messages.reservationConfirmed'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->redirect(route('my_bookings', $this->restaurant->hash), navigate: true);
    }

    public function render()
    {
        return view('livewire.shop.book-a-table');
    }

}
