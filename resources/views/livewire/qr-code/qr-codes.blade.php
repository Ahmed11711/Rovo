<div>
    <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.qrCodes')</h1>
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

            <div class="inline-flex items-center gap-3 lg:fixed bottom-10 right-5 lg:bg-white lg:px-3 lg:py-2 lg:shadow-md lg:rounded-md">
                <div class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-green-500" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                    @lang('modules.table.available')
                </div>
                <div class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-blue-500" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                    @lang('modules.table.running')
                </div>
                <div class="inline-flex items-center text-sm text-gray-600 gap-1 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill text-red-500" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                    @lang('modules.table.reserved')
                </div>
            </div>

        </div>

        <!-- Card Section -->
        <div class="space-y-8">
            @if(is_null($areaID) && branch()->qRCodeUrl)
            <div class="flex flex-col gap-3 sm:gap-4 space-y-1" wire:key='area-mainqr-{{ microtime() }}'>
                <!-- Card -->
                <div class="grid sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                    <div class='group flex flex-col gap-3 border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600 p-3' href="javascript:;">
                        <div class="w-full flex justify-center">
                            <img src="{{ branch()->qRCodeUrl }}" alt="QR Code">
                        </div>
                        <div class="flex items-center gap-4 justify-center w-full">
                            <x-secondary-button wire:click="downloadBranchQrCode" class="text-xs"
                                 data-tooltip-target="download-tooltip-toggle" type="button"
                                 data-tooltip-placement="top" >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </x-secondary-button>
                            <div id="download-tooltip-toggle" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                    @lang('app.download')
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            <x-secondary-link target="_blank" :href="route('table_order', [restaurant()->id]).'?branch=' . branch()->id . '&from_qr=1'" class="text-xs"
                            data-tooltip-target="visit-tooltip-toggle" type="button"
                            data-tooltip-placement="top" >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </x-secondary-link>
                            <div id="visit-tooltip-toggle" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                @lang('app.visitLink')
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @foreach ($tables as $area)

                <div class="flex flex-col gap-3 sm:gap-4 space-y-1" wire:key='area-{{ $area->id . microtime() }}'>
                    <h3 class="f-15 font-medium inline-flex gap-2 items-center dark:text-neutral-200">{{ $area->area_name }}
                        <span class="px-2 py-1 text-sm rounded bg-slate-100 border-gray-300 border text-gray-800 ">{{ $area->tables->count() }} @lang('modules.table.table')</span>
                    </h3>
                    <!-- Card -->

                    <div class="grid sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                        @foreach ($area->tables as $item)
                        <div
                        @class(['group flex flex-col gap-3 border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600 p-3', 'bg-red-50' => ($item->status == 'inactive'), 'bg-white' => ($item->status == 'active')])
                        wire:key='table-{{ $item->id . microtime() }}'
                            href="javascript:;">

                            <div class="flex items-center gap-4 justify-between w-full" >
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
                                        <div class="px-1 py-0.5 border border-red-700 text-xs text-red-700 rounded">@lang('modules.table.reserved')</div>
                                    @endif

                                    @if ($item->status == 'inactive')
                                        <div class="inline-flex text-xs gap-1 text-red-600 font-semibold">
                                            @lang('app.inactive')
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full flex justify-center">
                                <img src="{{ $item->qRCodeUrl }}" alt="">
                            </div>

                            <div class="flex items-center gap-4 justify-center w-full">
                                <x-secondary-button wire:click="downloadQrCode('{{ $item->table_code }}', '{{ $item->branch_id }}')" class="text-xs"
                                     data-tooltip-target="download-tooltip-toggle-{{$item->id}}" type="button"
                                     data-tooltip-placement="top" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </x-secondary-button>

                                <div id="download-tooltip-toggle-{{$item->id}}" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                        @lang('app.download')
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>

                                    <x-secondary-link target="_blank" href="{{ route('table_order', [$item->hash ,'from_qr' => 1]) }}" class="text-xs"
                                data-tooltip-target="visit-tooltip-toggle-{{$item->id}}" type="button"
                                data-tooltip-placement="top" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>

                                </x-secondary-link>

                                <div id="visit-tooltip-toggle-{{$item->id}}" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                    @lang('app.visitLink')
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>


                            </div>
                        </div>
                        <!-- End Card -->
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
        <!-- End Card Section -->


    </div>

</div>
