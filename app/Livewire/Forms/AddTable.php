<?php

namespace App\Livewire\Forms;

use App\Helper\Files;
use App\Models\Area;
use App\Models\Table;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class AddTable extends Component
{

    use LivewireAlert;

    public $tableCode;
    public $tableStatus = 'active';
    public $area;
    public $areas;
    public $seatingCapacity;

    public function mount()
    {
        $this->areas = Area::get();
    }

    public function resetForm()
    {
        $this->area = null;
        $this->seatingCapacity = null;
        $this->tableStatus = 'active';
        $this->tableCode = null;
    }

    public function submitForm()
    {
        $this->validate([
            'tableCode' => 'required|unique:tables,table_code,null,id,branch_id,' . branch()->id,
            'area' => 'required',
            'seatingCapacity' => 'required|integer',
        ]);

        $table = Table::create([
            'table_code' => $this->tableCode,
            'area_id' => $this->area,
            'seating_capacity' => $this->seatingCapacity,
            'status' => $this->tableStatus,
            'hash' => md5(microtime() . rand(1, 99999999)),
        ]);

        $table->generateQrCode();
        // Reset the value

        $this->resetForm();
        $this->dispatch('tableAdded');
        $this->dispatch('refreshTables');

        $this->alert('success', __('messages.tableAdded'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }


    public function render()
    {
        return view('livewire.forms.add-table');
    }

}
