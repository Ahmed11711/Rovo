<?php

namespace App\Livewire\Settings;

use App\Models\ReservationSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ReservationDaySettings extends Component
{

    use LivewireAlert;

    public $weekDay;
    public $dayTimeSlots;
    public $timeStart = [];
    public $timeSlotID = [];
    public $timeEnd = [];
    public $timeSlotDifference = [];
    public $timeSlotAvailable = [];

    public function mount()
    {
        $this->dayTimeSlots = ReservationSetting::where('day_of_week', $this->weekDay)->get();
        
        foreach ($this->dayTimeSlots as $value) {
            $this->timeSlotID[] = $value->id;
            $this->timeStart[] = $value->time_slot_start;
            $this->timeEnd[] = $value->time_slot_end;
            $this->timeSlotDifference[] = $value->time_slot_difference;
            $this->timeSlotAvailable[] = (bool)$value->available;
        }
    }

    public function submitForm()
    {
        $this->validateSlots();

        foreach ($this->timeSlotID as $key => $value) {
            ReservationSetting::where('id', $value)
                ->update([
                'time_slot_start' => $this->timeStart[$key],
                'time_slot_end' => $this->timeEnd[$key],
                'time_slot_difference' => $this->timeSlotDifference[$key],
                'available' => (bool)$this->timeSlotAvailable[$key],
            ]);
        }

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function validateSlots()
    {
        // Custom validation logic for overlapping slots
        foreach ($this->dayTimeSlots as $key => $slots) {
            $startTime = strtotime(now()->toDateString() .' '.$this->timeStart[$key]);
            $endTime = strtotime(now()->toDateString() .' '.$this->timeEnd[$key]);
            // Check for overlapping time slots
            if ($startTime > $endTime) {
                $this->addError('timeEnd.'.$key, __('messages.chooseEndTimeLater'));
            }
        }

        return true;
    }

    public function render()
    {
        return view('livewire.settings.reservation-day-settings');
    }

}
