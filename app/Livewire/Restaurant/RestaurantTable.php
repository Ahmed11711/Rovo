<?php

namespace App\Livewire\Restaurant;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RestaurantTable extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $search;
    public $restaurant;
    public $filterStatus;
    public $roles;
    public $showEditCustomerModal = false;
    public $confirmDeleteCustomerModal = false;
    public $showCustomerOrderModal = false;
    public $showChangePackageModal = false;
    public $showRejectionReasonModal = false;
    public $rejectionReason;

    protected $listeners = ['refreshRestaurants' => '$refresh'];

    public function showEditCustomer($id)
    {
        $this->restaurant = Restaurant::findOrFail($id);
        $this->showEditCustomerModal = true;
    }

    #[On('hideEditStaff')]
    public function hideEditStaff()
    {
        $this->showEditCustomerModal = false;
    }

    public function showChangePackage($id)
    {
        $this->restaurant = Restaurant::findOrFail($id);

        $this->showChangePackageModal = true;
    }

    #[On('hideChangePackage')]
    public function hideChangePackage()
    {
        $this->showChangePackageModal = false;
        $this->reset('restaurant');
    }

    public function showDeleteCustomer($id)
    {
        $this->restaurant = Restaurant::findOrFail($id);
        $this->confirmDeleteCustomerModal = true;
    }

    public function deleteCustomer($id)
    {
        Restaurant::destroy($id);

        $this->confirmDeleteCustomerModal = false;
        $this->reset('restaurant');
        $this->alert('success', __('messages.restaurantDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    #[On('hideEditCustomer')]
    public function hideEditCustomer()
    {
        $this->showEditCustomerModal = false;
    }


    public function confirmApprovalStatus($id, $status)
    {
        $this->restaurant = Restaurant::findOrFail($id);

        if ($this->restaurant->approval_status !== 'Pending') {
            $this->alert('error', __('messages.noRestaurantFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
            return;
        }
        
        $this->resetValidation();
        $this->reset('rejectionReason');
        
        if ($status == 'Rejected') {
            $this->showRejectionReasonModal = true;
        } else {
            $this->updateApprovalStatus($status);
        }
    }

    public function saveRejectionReason()
    {
        $this->validate([
            'rejectionReason' => 'required|string|max:255',
        ]);

        $this->restaurant->approval_status = 'Rejected';
        $this->restaurant->rejection_reason = $this->rejectionReason;
        $this->restaurant->save();

        $this->showRejectionReasonModal = false;
        $this->reset('rejectionReason', 'restaurant');
        $this->dispatch('updatedCount');
        $this->alert('success', __('messages.statusUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    private function updateApprovalStatus($status)
    {
        $this->restaurant->approval_status = $status;
        $this->restaurant->save();
        $this->reset('rejectionReason', 'restaurant');
        $this->dispatch('updatedCount');
        $this->alert('success', __('messages.statusUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        $query = Restaurant::with(['package', 'branches'])
        ->where(function ($q) {
            return $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
            ->orderByDesc('id')
            ->withCount('branches');

        if ($this->filterStatus != 'all') {
            $query->where('approval_status', $this->filterStatus);
        }

        $query = $query->paginate(20);

        return view('livewire.restaurant.restaurant-table', [
            'restaurants' => $query
        ]);
    }

}
