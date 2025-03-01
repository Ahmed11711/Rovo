<div class="mb-12">
    <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.waiterRequest')</h1>
            </div>
           
        </div>
    </div>

    <div class="flex flex-col my-4 px-4">


        <!-- Card Section -->
        <div class="space-y-8">
            @foreach ($tables as $area)

                <div class="flex flex-col gap-3 sm:gap-4 space-y-1" wire:key='area-{{ $area->id . microtime() }}'>
                    <h3 class="f-15 font-medium inline-flex gap-2 items-center dark:text-neutral-200">{{ $area->area_name }}
                        <span class="px-2 py-1 text-sm rounded bg-slate-100 border-gray-300 border text-gray-800 ">{{ $area->tables->count() }} @lang('modules.table.table')</span>
                    </h3>
                    <!-- Card -->

                    <div class="grid sm:grid-cols-3 2xl:grid-cols-4 gap-3 sm:gap-6">
                        @forelse ($area->tables as $item)
                        <a
                        @class(['group flex flex-col gap-2 border shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600 p-3', 'bg-red-50' => ($item->status == 'inactive'), 'bg-white' => ($item->status == 'active')])
           
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
                                    @class(['text-xs font-medium dark:text-neutral-200 text-gray-500 inline-flex items-center gap-1'])>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                                        <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z"/>
                                        <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3"/>
                                      </svg>
                                        {{ $item->activeWaiterRequest->created_at->diffForHumans() }}
                                    </p>

                                    <div class="flex items-center text-gray-600 text-sm gap-1 dark:text-gray-400">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 -2.89 122.88 122.88" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="enable-background:new 0 0 122.88 117.09" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style> <g> <path class="st0" d="M36.82,107.86L35.65,78.4l13.25-0.53c5.66,0.78,11.39,3.61,17.15,6.92l10.29-0.41c4.67,0.1,7.3,4.72,2.89,8 c-3.5,2.79-8.27,2.83-13.17,2.58c-3.37-0.03-3.34,4.5,0.17,4.37c1.22,0.05,2.54-0.29,3.69-0.34c6.09-0.25,11.06-1.61,13.94-6.55 l1.4-3.66l15.01-8.2c7.56-2.83,12.65,4.3,7.23,10.1c-10.77,8.51-21.2,16.27-32.62,22.09c-8.24,5.47-16.7,5.64-25.34,1.01 L36.82,107.86L36.82,107.86z M29.74,62.97h91.9c0.68,0,1.24,0.57,1.24,1.24v5.41c0,0.67-0.56,1.24-1.24,1.24h-91.9 c-0.68,0-1.24-0.56-1.24-1.24v-5.41C28.5,63.53,29.06,62.97,29.74,62.97L29.74,62.97z M79.26,11.23 c25.16,2.01,46.35,23.16,43.22,48.06l-93.57,0C25.82,34.23,47.09,13.05,72.43,11.2V7.14l-4,0c-0.7,0-1.28-0.58-1.28-1.28V1.28 c0-0.7,0.57-1.28,1.28-1.28h14.72c0.7,0,1.28,0.58,1.28,1.28v4.58c0,0.7-0.58,1.28-1.28,1.28h-3.89L79.26,11.23L79.26,11.23 L79.26,11.23z M0,77.39l31.55-1.66l1.4,35.25L1.4,112.63L0,77.39L0,77.39z"></path> </g> </g></svg>
                                        
                                        {{ $item->activeOrder->waiter->name ?? '--' }}
                                    </div>
                                    
                                    @if ($item->available_status == 'reserved')
                                        <div class="px-1 py-0.5 border bg-red-100 border-red-700 text-md text-red-700 rounded">@lang('modules.table.reserved')</div>
                                    @endif

                                    @if ($item->status == 'inactive')
                                        <div class="inline-flex text-xs gap-1 text-red-600 font-semibold">
                                            @lang('app.inactive')
                                        </div>
                                    @endif

                               
                                </div>
                            </div>
                            <div class="flex items-center gap-4 justify-between w-full">
                                <x-secondary-button wire:click='markCompleted({{ $item->activeWaiterRequest->id }})' class="text-xs flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
                                            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                                        </svg>
                                        @lang('modules.waiterRequest.markCompleted')
                                </x-secondary-button>

                                @if ($item->activeOrder)
                                    @if(user_can('Show Order'))
                                    <x-secondary-button wire:click='showTableOrderDetail({{ $item->id }})' class="text-xs">@lang('modules.order.showOrder')</x-secondary-button>
                                    @endif
                                @endif
                            </div>
                        </a>
                        <!-- End Card -->
                        @empty
                        <div class="col-span-full flex flex-col items-center justify-center p-8 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-lg">
                    
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mb-4 opacity-50 w-10 h-10" viewBox="0 0 16 16">
                                <path d="M5.164 14H15c-.299-.199-.557-.553-.78-1-.9-1.8-1.22-5.12-1.22-6q0-.396-.06-.776l-.938.938c.02.708.157 2.154.457 3.58.161.767.377 1.566.663 2.258H6.164zm5.581-9.91a4 4 0 0 0-1.948-1.01L8 2.917l-.797.161A4 4 0 0 0 4 7c0 .628-.134 2.197-.459 3.742q-.075.358-.166.718l-1.653 1.653q.03-.055.059-.113C2.679 11.2 3 7.88 3 7c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0c.942.19 1.788.645 2.457 1.284zM10 15a2 2 0 1 1-4 0zm-9.375.625a.53.53 0 0 0 .75.75l14.75-14.75a.53.53 0 0 0-.75-.75z"/>
                            </svg>
                            <p class="text-sm">@lang('modules.waiterRequest.noWaiterRequest')</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            @endforeach

        </div>
        <!-- End Card Section -->


    </div>


</div>
