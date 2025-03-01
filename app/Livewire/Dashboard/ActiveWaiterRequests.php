<?php

namespace App\Livewire\Dashboard;

use App\Models\WaiterRequest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ActiveWaiterRequests extends Component
{

    use LivewireAlert;

    protected $listeners = ['attended' => 'attended', 'newWaiterRequest' => 'render'];
    

    public function attended($data)
    {
       WaiterRequest::where('table_id', $data['tableID'])->update(['status' => 'completed']);
       $this->dispatch('newWaiterRequest');
    }

    public function render()
    {
        $playSound = false;

        $count = WaiterRequest::where('status', 'pending')->distinct('table_id')->count();
        
        $recentRequest = WaiterRequest::where('status', 'pending')->latest()->first();

        if (session()->has('active_waiter_requests_count') && session('active_waiter_requests_count') < $count) {
            $playSound = true;
            
            $this->dispatch('newWaiterRequest');

            $this->confirm(__('modules.waiterRequest.newWaiterRequestForTable', ['name' => $recentRequest->table->table_code]), [
                'position' => 'center',
                'confirmButtonText' => __('modules.waiterRequest.markCompleted'),
                'confirmButtonColor' => '#16a34a',
                'onConfirmed' => 'attended',
                'showCancelButton' => true,
                'cancelButtonText' => __('modules.waiterRequest.doItLater'),
                'onCanceled' => 'doItLater',
                'data' => [
                    'tableID' => $recentRequest->table_id
                ]
            ]);

        }

        session(['active_waiter_requests_count' => $count]);

        return view('livewire.dashboard.active-waiter-requests', [
            'count' => $count,
            'playSound' => $playSound
        ]);
    }
}
