<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            @lang('modules.package.editPackage')
        </h2>
    </x-slot>

    <div class="mx-auto ">
        <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
            @livewire('forms.edit-package', ['package' => $package])
        </div>
    </div>
</x-app-layout>
