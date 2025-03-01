<div>
    <div>

        <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.categoryReport')</h1>
                </div>
                <div class="items-center justify-between block sm:flex ">
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

                    <a href="javascript:;" wire:click='exportReport' class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                        @lang('app.export')
                    </a>
        
                </div>
            </div>

        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-2 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.menu.itemCategory')
                                    </th>
                                    <th scope="col"
                                        class="py-2 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.order.qty')
                                    </th>
                                    <th scope="col"
                                        class="py-2 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                        @lang('modules.order.amount')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='menu-item-list-{{ microtime() }}'>
    
                                @forelse ($menuItems as $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='menu-item-{{ $item->id . microtime() }}' wire:loading.class.delay='opacity-10'>
                                    <td class="py-2 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->category_name }}
                                    </td>
                                    <td class="py-2 px-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->orders->sum('quantity') }}
                                    </td>
                                    <td class="py-2 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        {{ currency_format($item->orders->sum('amount')) }}
                                    </td>
                                </tr>
                                @empty
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="py-2.5 px-4 space-x-6" colspan="5">
                                        @lang('messages.noItemAdded')
                                    </td>
                                </tr>
                                @endforelse
    
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>

    @script
    <script>
        const datepickerEl1 = document.getElementById('datepicker-range-start');

        datepickerEl1.addEventListener('changeDate', (event) => {
            $wire.dispatch('setStartDate', { start: datepickerEl1.value });
        });

        const datepickerEl2 = document.getElementById('datepicker-range-end');

        datepickerEl2.addEventListener('changeDate', (event) => {
            $wire.dispatch('setEndDate', { end: datepickerEl2.value });
        });
    </script>
    @endscript
</div>