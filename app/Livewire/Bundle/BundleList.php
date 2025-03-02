<?php

namespace App\Livewire\Bundle;

use App\Models\Menu;
use App\Models\User;
use App\Models\bundle;
use Livewire\Component;
use App\Models\bundle_product;

class BundleList extends Component
{
    public $bundles;
    public $name;
    public $desc;
    public $price;
    public $is_available = true;
    public $products = [];
    public $selectedProducts = [];
    public $showAddBundleModal = false;

    public function mount()
    {
        $this->loadBundles();
        $this->products = Menu::all();
    }

    public function loadBundles()
    {
        $this->bundles = Bundle::with('products')->get();
    }

    public function submitForm()
    {
        $this->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
            'price' => 'required|numeric',
            'selectedProducts' => 'array',
        ]);

        $bundle = Bundle::create([
            'name' => $this->name,
            'desc' => $this->desc,
            'price' => $this->price,
            'is_available' => $this->is_available,
        ]);

        foreach ($this->selectedProducts as $productId => $quantity) {
            $bundle->products()->attach($productId, ['quantity' => $quantity]);
        }

        $this->loadBundles();
        $this->showAddBundleModal = false;
    }

    public function showDeleteBundle($bundleId)
{
    $bundle = Bundle::find($bundleId);

    if ($bundle) {
        $bundle->delete();
        $this->loadBundles();
    }
}
    public function render()
    {
        return view('livewire.bundle.bundle', [
            'bundles' => $this->bundles,
            'products' => $this->products,
            'showAddBundleModal'=>$this->showAddBundleModal,
        ]);
    }
}
