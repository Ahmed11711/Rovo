<div class="w-full p-4 flex gap-4">

    <div>
        <x-dropdown align="left">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        @lang('modules.menu.filterCategory')
                        <div class="inline-flex items-center justify-center w-5 h-5 text-xs font-medium text-white bg-red-500  rounded-md  dark:border-gray-900 ml-1 {{ count($filterCategories) == 0 ? 'hidden' : '' }}">{{ count($filterCategories) }}</div>

                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                </span>
            </x-slot>

            <x-slot name="content">
                <!-- Account Management -->
                <div class="block px-4 py-2 text-sm font-medium text-gray-500">
                    <h6 class="text-sm font-medium text-gray-900 dark:text-white">
                        @lang('modules.menu.itemCategory')
                    </h6>
                </div>

                @foreach ($categoryList as $key => $item)
                    <x-dropdown-link wire:key='item-cat-{{ $item->id . microtime() }}'>
                        <input id="item-cat-{{ $item->id }}" type="checkbox" value="{{ $item->id }}" wire:model.live='filterCategories' wire:key='item-cat-input-{{ $item->id . microtime() }}'
                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-gray-600 focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                        <label for="item-cat-{{ $item->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100" wire:key='item-cat-label-{{ $item->id . microtime() }}'>
                        {{ $item->category_name }}
                        </label>
                    </x-dropdown-link>
                @endforeach

            </x-slot>
        </x-dropdown>
    </div>

    <div>
        <x-dropdown align="left">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        @lang('modules.menu.filterType')
                        <div class="inline-flex items-center justify-center w-5 h-5 text-xs font-medium text-white bg-red-500  rounded-md  dark:border-gray-900 ml-1 {{ count($filterTypes) == 0 ? 'hidden' : '' }}">{{ count($filterTypes) }}</div>
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                </span>
            </x-slot>

            <x-slot name="content">
                <!-- Account Management -->
                <div class="block px-4 py-2 text-sm font-medium text-gray-500">
                    <h6 class="text-sm font-medium text-gray-900 dark:text-white">
                        @lang('modules.menu.itemType')
                    </h6>
                </div>

                <x-dropdown-link class="flex items-center">
                    <input id="type-veg" type="checkbox" value="veg" wire:model.live='filterTypes' wire:key='item-type-input-{{ $item->id . microtime() }}'
                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-gray-600 focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                    <label for="type-veg" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100 inline-flex">
                        <img src="{{ asset('img/veg.svg')}}" class="h-5 mr-1" alt="" /> @lang('modules.menu.typeVeg')
                    </label>
                </x-dropdown-link>
                <x-dropdown-link class="flex items-center">
                    <input id="type-non-veg" type="checkbox" value="non-veg" wire:model.live='filterTypes' wire:key='item-type-input-{{ $item->id . microtime() }}'
                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-gray-600 focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                    <label for="type-non-veg" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100 inline-flex">
                        <img src="{{ asset('img/non-veg.svg')}}" class="h-5 mr-1" /> @lang('modules.menu.typeNonVeg')
                    </label>
                </x-dropdown-link>
                <x-dropdown-link class="flex items-center">
                    <input id="type-egg" type="checkbox" value="egg" wire:model.live='filterTypes' wire:key='item-type-input-{{ $item->id . microtime() }}'
                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-gray-600 focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                    <label for="type-egg" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100 inline-flex">
                        <img src="{{ asset('img/egg.svg')}}" class="h-5 mr-1" /> @lang('modules.menu.typeEgg')
                    </label>
                </x-dropdown-link>

            </x-slot>
        </x-dropdown>
    </div>

    <div>
        <x-dropdown align="left">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        @lang('modules.menu.filterAvailability')
                        @if (!empty($filterAvailability))
                            <div class="inline-flex items-center justify-center w-5 h-5 text-xs font-medium text-white bg-red-500 rounded-md dark:border-gray-900 ml-1" wire:key="check-count-of-filters">1</div>
                        @endif
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                </span>
            </x-slot>

            <x-slot name="content">
                <div class="block px-4 py-2 text-sm font-medium text-gray-500">
                    <h6 class="text-sm font-medium text-gray-900 dark:text-white">
                        @lang('modules.menu.itemAvailability')
                    </h6>
                </div>
                <x-dropdown-link class="flex items-center">
                    <input id="availability-available" type="radio" value="1" wire:model.live='filterAvailability'
                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-gray-600 focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                    <label for="availability-available" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                        @lang('modules.menu.available')
                    </label>
                </x-dropdown-link>
                <x-dropdown-link class="flex items-center">
                    <input id="availability-not-available" type="radio" value="0" wire:model.live='filterAvailability'
                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-gray-600 focus:ring-gray-500 dark:focus:ring-gray-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                    <label for="availability-not-available" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                        @lang('modules.menu.notAvailable')
                    </label>
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    </div>

    @if ($clearFilterButton)
        <div wire:key='filter-btn-{{ microtime() }}'>
            <x-danger-button wire:click='clearFilters'>
                <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                @lang('app.clearFilter')
            </x-danger-button>
        </div>
    @endif

    <div>
        <x-secondary-button wire:click="$toggle('showFilters')">@lang('app.hideFilter')</x-secondary-button>
    </div>

</div>
