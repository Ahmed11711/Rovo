<?php

namespace App\Livewire\OfflinePayment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OfflinePaymentMethod;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OfflinePaymentMethodTab extends Component
{
    use WithPagination, LivewireAlert;

    public $name;
    public $description;
    public $status = 'active';
    public $methodId;
    public $showPaymentMethodForm = false;
    public $confirmDeleteModal = false;
    public $deleteId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'status' => 'required|in:active,inactive',
    ];

    public function submitForm()
    {
        $this->validate();

        OfflinePaymentMethod::updateOrCreate(
            ['id' => $this->methodId],
            ['name' => $this->name, 'description' => $this->description, 'status' => $this->status]
        );

        $this->alert('success', $this->methodId ? __('messages.offlinePaymentMethodUpdated') : __('messages.offlinePaymentMethodAdded'), [
            'toast' => true, 'position' => 'top-end'
        ]);

        $this->resetForm();
    }

    public function addOfflinePayMethod()
    {
        $this->resetForm();
        $this->showPaymentMethodForm = true;
    }

    public function editPaymentMethod($id)
    {
        $paymentMethod = OfflinePaymentMethod::findOrFail($id);
        $this->methodId = $paymentMethod->id;
        $this->name = $paymentMethod->name;
        $this->description = $paymentMethod->description;
        $this->status = $paymentMethod->status;
        $this->showPaymentMethodForm = true;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmDeleteModal = true;
    }

    public function delete()
    {
        OfflinePaymentMethod::findOrFail($this->deleteId)->delete();
        $this->alert('success', __('messages.offlinePaymentMethodDeleted'), [
            'toast' => true, 'position' => 'top-end'
        ]);
        $this->deleteId = null;
        $this->confirmDeleteModal = false;
    }

    private function resetForm()
    {
        $this->methodId = null;
        $this->name = $this->description = '';
        $this->status = 'active';
        $this->showPaymentMethodForm = false;
    }

    public function render()
    {
        $methods = OfflinePaymentMethod::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.offline-payment.offline-payment-method-tab', compact('methods'));
    }
}
