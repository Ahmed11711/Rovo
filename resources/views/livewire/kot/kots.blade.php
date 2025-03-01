<div wire:poll.10s>
    <div class="p-4 bg-white block  dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.kot')</h1>
        </div>

        <div class="items-center justify-between block sm:flex ">
            <div class="lg:flex items-center mb-4 sm:mb-0">

                <div class="lg:flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        
                        <div class="lg:flex gap-2 items-center">
                            <x-select id="dateRangeType" class="block w-fit" wire:model="dateRangeType"
                             wire:change="setDateRange">
                                <option value="today">@lang('app.today')</option>
                                <option value="currentWeek">@lang('app.currentWeek')</option>
                                <option value="lastWeek">@lang('app.lastWeek')</option>
                                <option value="last7Days">@lang('app.last7Days')</option>
                                <option value="currentMonth">@lang('app.currentMonth')</option>
                                <option value="lastMonth">@lang('app.lastMonth')</option>
                                <option value="currentYear">@lang('app.currentYear')</option>
                                <option value="lastYear">@lang('app.lastYear')</option>
                            </x-select>
    
                            <div id="date-range-picker" date-rangepicker class="flex items-center w-full">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-start" name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.change='startDate' placeholder="@lang('app.selectStartDate')">
                                    </div>
                                    <span class="mx-4 text-gray-500">@lang('app.to')</span>
                                    <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-end" name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live='endDate' placeholder="@lang('app.selectEndDate')">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="lg:inline-flex gap-2">

                    <div wire:click="$set('filterOrders', 'in_kitchen')" @class(['whitespace-nowrap items-center font-medium
                        cursor-pointer p-2 text-center rounded-md text-sm border hover:text-gray-900 bg-white
                        hover:bg-gray-200 w-full dark:bg-gray-800 dark:hover:bg-gray-700
                        dark:hover:text-white dark:text-neutral-400', ' border-2 border-gray-700 dark:border-gray-500'=> ($filterOrders == 'in_kitchen')])>
                        @lang('modules.order.in_kitchen') ({{ $inKitchenCount }})
                    </div>
                    <div wire:click="$set('filterOrders', 'food_ready')" @class(['whitespace-nowrap items-center font-medium
                        cursor-pointer p-2 text-center rounded-md text-sm border hover:text-gray-900 bg-white
                        hover:bg-gray-200 w-full dark:bg-gray-800 dark:hover:bg-gray-700
                        dark:hover:text-white dark:text-neutral-400', ' border-2 border-gray-700 dark:border-gray-500'=> ($filterOrders == 'food_ready')])>
                    @lang('modules.order.food_ready') ({{ $foodReadyCount }})
                    </div>
                    <div wire:click="$set('filterOrders', 'served')" @class(['whitespace-nowrap items-center font-medium
                        cursor-pointer p-2 text-center rounded-md text-sm border hover:text-gray-900 bg-white
                        hover:bg-gray-200 w-full dark:bg-gray-800 dark:hover:bg-gray-700
                        dark:hover:text-white dark:text-neutral-400', ' border-2 border-gray-700 dark:border-gray-500'=> ($filterOrders == 'served')])>
                        @lang('modules.order.served') ({{ $servedCount }})
                    </div>

                </div>
            </div>

        </div>

        <div class="flex flex-col my-4">

            <!-- Card Section -->
            <div class="space-y-4">
                <div class="grid sm:grid-cols-3 2xl:grid-cols-4 gap-3 sm:gap-4">
                    @foreach ($kots as $item)
                    @livewire('kot.kot-card', ['kot' => $item], key('kot-' . $item->id . microtime()))
                    @endforeach
                </div>
            </div>
            <!-- End Card Section -->


        </div>

    </div>