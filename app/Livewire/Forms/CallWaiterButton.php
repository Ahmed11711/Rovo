<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\WaiterRequest;
use App\Models\Table;

class CallWaiterButton extends Component
{

    public $showConfirmation = false;
    public $notificationSent = false;
    public $tableNumber;
    public $tables;
    public $shopBranch;
    public $showTableSelection = false;
    public $table;

    public function mount()
    {
        $this->tableNumber = $this->tableNumber;
        $this->table = Table::where('id', $this->tableNumber)->first();
        $this->tables = Table::where('branch_id', $this->shopBranch->id)->get();
    }

    public function callWaiter()
    {
        if (!$this->tableNumber) {
            $this->showTableSelection = true;
        } else {
            $this->showConfirmation = true;
        }
    }

    public function selectTable($tableId)
    {
        $this->tableNumber = $tableId;
        $this->table = Table::where('id', $tableId)->first();

        $this->showTableSelection = false;
        $this->showConfirmation = true;
    }

    public function confirmCall()
    {
        // Save request to database
        WaiterRequest::create([
            'table_id' => $this->tableNumber,
            'branch_id' => $this->shopBranch->id,
            'status' => 'Pending',
        ]);

        $this->showConfirmation = false;
        $this->notificationSent = true;
    }

    public function cancelCall()
    {
        $this->showConfirmation = false;
        $this->showTableSelection = false;
    }

    public function render()
    {
        return view('livewire.forms.call-waiter-button');
    }
}
