<div>
    @if($showAddPackage)
        <div class="p-7">
            @livewire('forms.addPackage')
        </div>
    @elseif($showEditPackageModal)
        <div class="p-7">
            @livewire('forms.edit-package', ['package' => $package], key(str()->random(50)))
        </div>
    @else
    <div>
        <div class="items-center justify-between block p-4 bg-white sm:flex dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.packages')</h1>
                </div>
                <div class="items-center justify-between block sm:flex ">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Search</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <x-input id="menu_name" class="block w-full mt-1" type="text" placeholder="{{ __('placeholders.searchPackages') }}" wire:model.live.debounce.500ms="search"  />
                            </div>
                        </form>
                    </div>

                    <x-primary-link href="{{ route('superadmin.packages.create') }}" wire:navigate class="text-sm font-medium text-blue-600 hover:underline">@lang('modules.package.addPackage')</x-primary-button>

                </div>
            </div>
        </div>

        <livewire:package.package-table :search='$search' key='package-table-{{ microtime() }}' />
    </div>
    @endif
</div>
