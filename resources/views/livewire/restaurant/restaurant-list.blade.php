<div>
    <div>

        <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('superadmin.menu.restaurants')</h1>
                </div>
                @if($showRegenerateQrCodes)
                    <x-alert type="warning" class="flex justify-between" >
                        <span>@lang('superadmin.domainChanged')</span>

                        <span><x-button type='button' wire:click="regenerateQrCodes()" >@lang('superadmin.regenerateQrCode')</x-button></span>
                    </x-alert>
                @endif
                <div class="items-center justify-between block sm:flex">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Search</label>
                            <div class="relative w-48 sm:w-64 xl:w-96">
                                <x-input id="menu_name" class="block w-full" type="text" placeholder="{{ __('placeholders.searchStaffmember') }}" wire:model.live.debounce.500ms="search"  />
                            </div>
                        </form>

                        <button wire:click="$set('filterStatus', 'pending')"
                        class="px-3 py-2 text-sm font-medium text-center text-gray-600 bg-white border-skin-base border rounded-md dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            @lang('modules.restaurant.needApproval')
                            <span class="inline-flex items-center justify-center px-2 py-0.5 ms-2 text-xs font-semibold text-white bg-skin-base rounded-md">
                                {{ $count }}
                            </span>
                        </button>

                        @if($filterStatus !== 'all')
                        <x-danger-button class="ms-2" wire:click="$set('filterStatus', 'all')">
                            <svg aria-hidden="true" class="w-5 h-5 -ml-1 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
                            @lang('app.clearFilter')
                        </x-danger-button>
                        @endif
                    </div>


                    <x-button type='button' wire:click="$set('showAddRestaurant', true)" >@lang('modules.restaurant.addRestaurant')</x-button>

                </div>
            </div>
        </div>

        <livewire:restaurant.restaurant-table :search='$search' :filterStatus='$filterStatus' key='restaurant-table-{{ microtime() }}' />


    </div>



    <x-right-modal wire:model.live="showAddRestaurant">
        <x-slot name="title">
            {{ __("modules.restaurant.addRestaurant") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.addRestaurant')
        </x-slot>
    </x-right-modal>

</div>
