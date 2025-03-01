<?php

namespace App\Livewire\Area;

use App\Models\Area;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Areas extends Component
{
    use LivewireAlert;

    public $showAddAreaModal = false;
    public $showEditAreaModal = false;
    public $confirmDeleteAreaModal = false;
    public $activeArea;

    #[On('hideAddArea')]
    public function hideAddArea()
    {
        $this->showAddAreaModal = false;
    }

    public function showEditArea($id)
    {
        $this->activeArea = Area::findOrFail($id);
        $this->showEditAreaModal = true;
    }

    public function showDeleteArea($id)
    {
        $this->confirmDeleteAreaModal = true;
        $this->activeArea = Area::findOrFail($id);
    }

    #[On('hideEditArea')]
    public function hideEditArea()
    {
        $this->showEditAreaModal = false;
    }

    public function deleteArea($id)
    {
        Area::destroy($id);
        $this->confirmDeleteAreaModal = false;

        $this->alert('success', __('messages.areaDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->activeArea = false;
    }

    public function render()
    {
        return view('livewire.area.areas', [
            'areas' => Area::withCount('tables')->get()
        ]);
    }

}
