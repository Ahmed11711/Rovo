<div>
    <div class="flex flex-col my-4 grid gap-6 grid-cols-3">
        <!-- Card Section -->
        <div class="space-y-8 col-span-2">
            @foreach ($tables as $area)

                <div class="flex flex-col gap-3 sm:gap-4 space-y-3" wire:key='area-{{ $area->id . microtime() }}'>
                    <h3 class="f-15 font-medium inline-flex gap-2 items-center dark:text-neutral-200">{{ $area->area_name }}
                        <span class="px-2 py-1 text-sm rounded bg-slate-100 border-gray-300 border text-gray-800 ">{{ $area->tables->count() }} @lang('modules.table.table')</span>
                    </h3>
                    <!-- Card -->

                    <div class="grid sm:grid-cols-3 gap-3 sm:gap-4">
                        @foreach ($area->tables as $item)
                        <a
                        @class(['group flex items-center justify-center border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600', 'bg-red-50' => ($item->status == 'inactive'), 'bg-white' => ($item->status == 'active')]) wire:click='setOrderTable({{ $item }})'
                        wire:key='table-{{ $item->id . microtime() }}'
                            href="javascript:;">
                            <div class="p-3">
                                <div class="flex flex-col space-y-2 items-center justify-center">
                                    @if ($item->status == 'inactive')
                                        <div class="inline-flex text-xs gap-1 text-red-600 font-semibold">
                                            @lang('app.inactive')
                                        </div>
                                    @endif
                                    <div @class(['p-2 rounded-lg tracking-wide ',
                                    'bg-green-100 text-green-600' => ($item->available_status == 'available'),
                                    'bg-red-100 text-red-600' => ($item->available_status == 'reserved'),
                                    'bg-blue-100 text-blue-600' => ($item->available_status == 'running')])>
                                        <h3 wire:loading.class.delay='opacity-50'
                                            @class(['font-semibold'])>
                                            {{ $item->table_code }}
                                        </h3>
                                    </div>
                                    <p
                                    @class(['text-xs font-medium dark:text-neutral-200 text-gray-500'])>
                                        {{ $item->seating_capacity }} @lang('modules.table.seats')
                                    </p>
                                </div>
                            </div>
                        </a>
                        <!-- End Card -->
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
        <!-- End Card Section -->


        <div class="col-span-1 space-y-3">
            <h4 class="text-base font-medium">@lang('modules.reservation.todayReservations')</h4>

            @forelse ($reservations as $item)
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 p-2">
                <div class="flex justify-between">
                    <div class="text-base font-semibold text-gray-800 dark:text-white">
                        <div @class(['p-2 rounded-md tracking-wide bg-skin-base/[0.2] text-skin-base'])>
                            <h3 wire:loading.class.delay='opacity-50'
                                @class(['font-semibold'])>
                                {{ $item->table->table_code }}
                            </h3>
                        </div>
                    </div>
                    <div class=" text-gray-700 dark:text-neutral-400 flex flex-col space-y-1">
                        <div class="inline-flex gap-2 items-center text-xs">
                            {{ $item->party_size }} @lang('modules.reservation.guests')
                        </div>

                        <div class="inline-flex gap-2 items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                            </svg>
                            {{ $item->reservation_date_time->translatedFormat('h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div>
                @lang('messages.noTableReserved')
            </div>
            @endforelse
        </div>

    </div>

</div>
