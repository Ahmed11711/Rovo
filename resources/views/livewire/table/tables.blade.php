<div class="mb-12">
    <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('modules.table.tableView')</h1>
            </div>
            <div class="items-center justify-between block sm:flex dark:divide-gray-700">
                <div class="flex items-center gap-4">
                    <!-- View Toggle -->
                    <div class="inline-flex rounded-lg shadow-sm">
                        <button type="button" wire:click="$set('viewType', 'list')"
                            @class(['relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-l-lg focus:z-10', 
                            'bg-skin-base text-white' => $viewType === 'list',
                            'bg-white text-gray-700 hover:text-gray-900 border border-gray-200 hover:bg-gray-50' => $viewType !== 'list'])>
                            <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            @lang('app.list')
                        </button>
                        <button type="button" wire:click="$set('viewType', 'grid')"
                            @class(['relative inline-flex items-center px-3 py-2 text-sm font-medium focus:z-10', 
                            'bg-skin-base text-white' => $viewType === 'grid',
                            'bg-white text-gray-700 hover:text-gray-900 border border-gray-200 hover:bg-gray-50' => $viewType !== 'grid'])>
                            <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            @lang('app.grid')
                        </button>
                        <button type="button" wire:click="$set('viewType', 'layout')"
                            @class(['relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-r-lg focus:z-10', 
                            'bg-skin-base text-white' => $viewType === 'layout',
                            'bg-white text-gray-700 hover:text-gray-900 border border-gray-200 hover:bg-gray-50' => $viewType !== 'layout'])>
                            <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                            </svg>
                            @lang('app.layout')
                        </button>
                    </div>
                    
                    <x-dropdown align="left" dropdownClasses="z-10">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    @if (is_null($filterAvailable))
                                        @lang('modules.table.filterAvailable')
                                    @else
                                        <span class="font-bold text-gray-800">@lang('app.showing') @lang('modules.table.' . $filterAvailable)</span>
                                    @endif
                        
                                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
            
                        <x-slot name="content">
                            <x-dropdown-link class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium cursor-pointer" wire:click="$set('filterAvailable',  null)">
                                @lang('app.showAll')
                            </x-dropdown-link>
                            <x-dropdown-link class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium cursor-pointer" wire:click="$set('filterAvailable', 'available')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-green-500" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8"/>
                                </svg>
                                @lang('modules.table.available')
                            </x-dropdown-link>
                            <x-dropdown-link class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium cursor-pointer" wire:click="$set('filterAvailable', 'running')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-blue-500" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8"/>
                                </svg>
                                @lang('modules.table.running')
                            </x-dropdown-link>
                            <x-dropdown-link class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium cursor-pointer" wire:click="$set('filterAvailable', 'reserved')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-red-500" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8"/>
                                </svg>
                                @lang('modules.table.reserved')
                            </x-dropdown-link>
                        
                        </x-slot>
                    </x-dropdown>
                </div>

                @if(user_can('Create Table'))
                <div class="gap-2 flex">
                    <x-button type='button' wire:click="$toggle('showAddTableModal')" >@lang('modules.table.addTable')</x-button>    
                </div>
                @endif

            </div>
        </div>
    </div>

    <div class="flex flex-col my-4 px-4">
        <div class="mb-6 lg:flex lg:justify-between">
            <ul class="inline-flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400 mb-4">
                <li class="me-2" wire:key='area-fltr-{{ microtime() }}'>
                    <a href="javascript:;" wire:click="$set('areaID', null)"
                    @class(['inline-block px-4 py-3 rounded-lg', 'text-skin-base dark:bg-skin-base/[.1] bg-skin-base/[.2]' => (is_null($areaID)), 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' => (!is_null($areaID))]) >@lang('modules.table.allAreas')</a>
                </li>

                @foreach ($areas as $item)
                    <li class="me-2" wire:key='area-fltr-{{ $item->id.microtime() }}'>
                        <a href="javascript:;" wire:click="$set('areaID', '{{ $item->id }}')"
                            @class(['inline-block px-4 py-3 rounded-lg', 'text-skin-base dark:bg-skin-base/[.1] bg-skin-base/[.2]' => ($areaID == $item->id), 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' => ($areaID != $item->id)]) >
                            {{ $item->area_name }}
                        </a>
                    </li>
                @endforeach

            </ul>

            <div class="inline-flex items-center gap-3 lg:fixed bottom-10 right-5 lg:bg-white dark:bg-gray-700 lg:px-3 lg:py-2 lg:shadow-md lg:rounded-md">
                <div class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium dark:text-neutral-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-green-500" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                    @lang('modules.table.available')
                </div>
                <div class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium dark:text-neutral-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-blue-500" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                    @lang('modules.table.running')
                </div>
                <div class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium dark:text-neutral-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-red-500" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                    @lang('modules.table.reserved')
                </div>
            </div>

        </div>

        <!-- Card Section -->
        <div class="space-y-8">
            @foreach ($tables as $area)
                <div class="flex flex-col gap-3 sm:gap-4 space-y-1" wire:key='area-{{ $area->id . microtime() }}'>
                    <h3 class="f-15 font-medium inline-flex gap-2 items-center dark:text-neutral-200">{{ $area->area_name }}
                        <span class="px-2 py-1 text-sm rounded bg-slate-100 border-gray-300 border text-gray-800 ">{{ $area->tables->count() }} @lang('modules.table.table')</span>
                    </h3>

                    @if($viewType === 'layout')
                        <div class="relative bg-gray-50 dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <!-- Tables Layout -->
                            <div class="relative grid grid-cols-6 gap-2 p-4">
                                @foreach ($area->tables as $item)
                                    <x-restaurant-table
                                        wire:key='table-{{ $item->id . microtime() }}'
                                        wire:click='showTableOrder({{ $item->id }})'
                                        :shape="$item->seating_capacity >= 4 ? 'rectangle' : 'circle'"
                                        :seats="$item->seating_capacity"
                                        :code="$item->table_code"
                                        :status="$item->available_status"
                                        :is-inactive="$item->status === 'inactive'"
                                        :kot-count="$item->activeOrder ? $item->activeOrder->kot->count() : 0"
                                        class="scale-75"
                                    />
                                @endforeach
                            </div>
                        </div>
                    @elseif($viewType === 'grid')
                    <div class="grid grid-cols-8 gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        @foreach ($area->tables as $item)
                            <div wire:key='table-{{ $item->id . microtime() }}'
                                wire:click='showTableOrder({{ $item->id }})'
                                @class([
                                    'aspect-square rounded-lg p-2 cursor-pointer flex flex-col items-center justify-center transition-all transform hover:scale-105',
                                    'bg-green-100 border-green-200' => $item->available_status == 'available',
                                    'bg-red-100 border-red-200' => $item->available_status == 'reserved',
                                    'bg-blue-100 border-blue-200' => $item->available_status == 'running',
                                    'opacity-50' => $item->status == 'inactive'
                                ])>
                                <span class="text-lg font-bold">{{ $item->table_code }}</span>
                                <span class="text-xs">{{ $item->seating_capacity }} @lang('modules.table.seats')</span>
                                @if($item->activeOrder)
                                    <span class="text-xs mt-1">{{ $item->activeOrder->kot->count() }} @lang('modules.order.kot')</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @else
                        <div class="grid sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($area->tables as $item)
                            <a
                            @class(['group flex flex-col gap-2 border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600 p-3', 'bg-red-50' => ($item->status == 'inactive'), 'bg-white' => ($item->status == 'active')])
                            {{-- wire:click='showEditTable({{ $item->id }})' --}}
                            wire:key='table-{{ $item->id . microtime() }}'
                                href="javascript:;">
                                <div class="flex items-center gap-4 justify-between w-full cursor-pointer" wire:click='showTableOrder({{ $item->id }})'>
                                    <div @class(['p-3 rounded-lg tracking-wide ',
                                    'bg-green-100 text-green-600' => ($item->available_status == 'available'),
                                    'bg-red-100 text-red-600' => ($item->available_status == 'reserved'),
                                    'bg-blue-100 text-blue-600' => ($item->available_status == 'running')])>
                                        <h3 wire:loading.class.delay='opacity-50'
                                            @class(['font-semibold'])>
                                            {{ $item->table_code }}
                                        </h3>
                                    </div>
                                    <div class="space-y-1">
                                        <p
                                        @class(['text-xs font-medium dark:text-neutral-200 text-gray-500'])>
                                            {{ $item->seating_capacity }} @lang('modules.table.seats')
                                        </p>
                                        
                                        @if ($item->available_status == 'reserved')
                                            <div class="px-1 py-0.5 border bg-red-100 border-red-700 text-md text-red-700 rounded">@lang('modules.table.reserved')</div>
                                        @endif

                                        @if ($item->status == 'inactive')
                                            <div class="inline-flex text-xs gap-1 text-red-600 font-semibold">
                                                @lang('app.inactive')
                                            </div>
                                        @endif

                                        <p class="text-sm font-medium dark:text-neutral-400">
                                            {{ $item->activeOrder ? $item->activeOrder->kot->count() . ' ' . __('modules.order.kot') : '' }}
                                        </p>
                                    </div>
                                </div>
                                    <div class="flex items-center gap-4 justify-between w-full">
                                        @if ($item->activeOrder)
                                            @if(user_can('Show Order'))
                                            <x-secondary-button wire:click='showTableOrderDetail({{ $item->id }})' class="text-xs">@lang('modules.order.showOrder')</x-secondary-button>
                                            @endif
                                            
                                            @if ($item->activeOrder->status == 'kot' && user_can('Create Order'))
                                                <x-secondary-button class="text-xs" wire:click='showTableOrder({{ $item->id }})'>@lang('modules.order.newKot')</x-secondary-button>
                                            @endif
                                        @endif

                                        @if(user_can('Update Table'))
                                        <x-secondary-button wire:click='showEditTable({{ $item->id }})' class="text-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                              </svg>
                                        </x-secondary-button>
                                        @endif

                                    </div>
                            </a>
                            <!-- End Card -->
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
        <!-- End Card Section -->


    </div>

    <x-right-modal wire:model.live="showAddTableModal">
        <x-slot name="title">
            {{ __("modules.table.addTable") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.addTable')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showAddTableModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    @if ($activeTable)
    <x-right-modal wire:model.live="showEditTableModal">
        <x-slot name="title">
            {{ __("modules.table.editTable") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.editTable', ['activeTable' => $activeTable], key(str()->random(50)))
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditTableModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>
    @endif

</div>
