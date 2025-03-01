<?php

namespace App\Livewire\Package;

use App\Models\Package;
use Livewire\Component;
use Livewire\Attributes\On;

class PackageList extends Component
{
    public $search;
    public $package;
    public $showAddPackage = false;
    public $showEditPackageModal = false;

    #[On('hideAddPackage')]
    public function hideAddPackage()
    {
        $this->showAddPackage = false;
    }

    public function showEditPackage($id)
    {
        $this->package = Package::findOrFail($id);
        $this->showEditPackageModal = true;
    }

    #[On('hideEditPackage')]
    public function hideEditPackage()
    {
        $this->showEditPackageModal = false;
    }

    public function render()
    {
        return view('livewire.package.package-list');
    }
}
