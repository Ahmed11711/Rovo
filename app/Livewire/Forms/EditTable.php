<?php

namespace App\Livewire\Forms;

use App\Models\Area;
use App\Models\Table;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Helper\Files;


class EditTable extends Component
{
    use LivewireAlert;

    public $activeTable;
    public $tableCode;
    public $tableStatus = 'active';
    public $area;
    public $areas;
    public $seatingCapacity;
    public $tableAvailability;
    public $confirmDeleteTableModal = false;

    public function mount()
    {
        $this->areas = Area::get();
        $this->area = $this->activeTable->area_id;
        $this->seatingCapacity = $this->activeTable->seating_capacity;
        $this->tableStatus = $this->activeTable->status;
        $this->tableCode = $this->activeTable->table_code;
        $this->tableAvailability = $this->activeTable->available_status;
    }

    public function submitForm()
    {
        $this->validate([
            'tableCode' => 'required|unique:tables,table_code,' . $this->activeTable->id . ',id,branch_id,' . branch()->id,
            'area' => 'required',
            'seatingCapacity' => 'required|integer',
        ]);

        $table = Table::findOrFail($this->activeTable->id);

        $doQrCode = false;
        if ($table->table_code !== $this->tableCode) {
            Files::deleteFile($table->getQrCodeFileName(), 'qrcodes');
            $doQrCode = true;
        }

        $table->update([
            'table_code' => $this->tableCode,
            'area_id' => $this->area,
            'seating_capacity' => $this->seatingCapacity,
            'status' => $this->tableStatus,
            'available_status' => $this->tableAvailability,
        ]);


        if ($doQrCode) {
            $table->fresh()->generateQrCode();
        }

        // Reset the value

        $this->dispatch('refreshTables');
        $this->dispatch('hideEditTable');

        $this->alert('success', __('messages.tableUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function showDeleteTable()
    {
        $this->confirmDeleteTableModal = true;
    }

    public function deleteTable()
    {
        Table::destroy($this->activeTable->id);

        $this->redirect(route('tables.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.forms.edit-table');
    }
}
