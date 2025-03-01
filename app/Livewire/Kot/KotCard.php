<?php

namespace App\Livewire\Kot;

use App\Models\Kot;
use Livewire\Component;

class KotCard extends Component
{
    public $kot;
    public $confirmDeleteKotModal = false;

    public function changeKotStatus($status)
    {
        Kot::where('id', $this->kot->id)->update([
            'status' => $status
        ]);

        $this->dispatch('refreshKots');
    }

    public function deleteKot($id)
    {
        $order = Kot::find($id)->order;
        $kotCounts = $order->kot->count();
        
        if ($kotCounts == 1) {
            $order->status = 'canceled';
            $order->save();

            if ($order->table) {
                $order->table->update(['available_status' => 'available']);
            }
        }

        Kot::destroy($id);
        $this->confirmDeleteKotModal = false;
        
        $this->dispatch('refreshKots');

        if ($kotCounts == 1) {
            $order->delete();
        }
    }

    public function render()
    {
        return view('livewire.kot.kot-card');
    }

}
