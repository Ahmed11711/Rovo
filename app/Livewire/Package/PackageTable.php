<?php

namespace App\Livewire\Package;

use App\Models\Module;
use App\Models\Package;
use App\Models\Restaurant;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PackageTable extends Component
{
    use LivewireAlert;
    use WithPagination, WithoutUrlPagination;

    public $search;
    public $package;
    public $roles;
    public $showEditPackageModal = false;
    public $confirmDeletePackageModal = false;
    public $allModules;
    public $packageDelete;
    public $additionalFeatures;
    protected $listeners = ['refreshPackages' => '$refresh'];

    public function mount()
    {
        $this->allModules = Module::all();
        $this->additionalFeatures = Package::ADDITIONAL_FEATURES;
    }

    public function showDeletePackage($id)
    {
        $this->packageDelete = Package::findOrFail($id);
        $this->confirmDeletePackageModal = true;
    }

    public function deletePackage($id)
    {
        $checkIfPackageIsUsed = Restaurant::where('package_id', $id)->first();
        if($checkIfPackageIsUsed){
            $this->alert('error', __('messages.packageIsUsed'), [
                'toast' => false,
                'position' => 'center',
                'showCancelButton' => true,
                'cancelButtonText' => __('app.close')
            ]);

            return;
        }
        Package::destroy($id);

        $this->confirmDeletePackageModal = false;

        $this->reset('packageDelete');
        $this->alert('success', __('messages.packageDeleted'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

    }

    public function render()
    {
        $query = Package::with('modules','currency')
            ->where(function($q) {
            $q->where('package_name', 'like', '%'.$this->search.'%')
            ->orWhere('package_type', 'like', '%'.$this->search.'%');
            })
            ->paginate(20);

        return view('livewire.package.package-table', [
            'packages' => $query
        ]);
    }

}
