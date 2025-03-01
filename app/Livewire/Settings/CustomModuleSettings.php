<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Nwidart\Modules\Facades\Module;
use Froiden\Envato\Functions\EnvatoUpdate;
use Macellan\Zip\Zip;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Froiden\Envato\Traits\ModuleVerify;

class CustomModuleSettings extends Component
{

    use ModuleVerify;

    public $updateFilePath;

    public function mount()
    {
        $this->updateFilePath = config('froiden_envato.tmp_path');
        /** @phpstan-ignore-next-line */
        // $this->allModules = Module::toCollection()->filter(function ($module, $key) {
        //     return $key !== 'UniversalBundle';
        // });

        // $this->customPlugins = Module::allEnabled();
    }

    public function render()
    {
        $allModules = Module::toCollection();
        $customPlugins = Module::allEnabled();

        return view('livewire.settings.custom-module-settings', [
            'allModules' => $allModules,
            'customPlugins' => $customPlugins,
        ]);
    }
}
