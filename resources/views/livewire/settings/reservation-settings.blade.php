<div>
    
    <div class="flex flex-col my-4 px-4">
        <!-- Card Section -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-4">
            @foreach ($reservationSettings as $key => $item)
            <!-- Card -->
            <a
            @class(['group flex flex-col border shadow-sm rounded-lg hover:shadow-md transition', 'bg-skin-base dark:bg-skin-base dark:border-skin-base' => ($weekDay == $item->day_of_week), 'bg-white dark:bg-gray-700 dark:border-gray-600' => ($weekDay != $item->day_of_week)])
            wire:key='menu-{{ $key . microtime() }}' wire:click="showItems('{{ $item->day_of_week }}')"
                href="javascript:;">
                <div class="p-3">
                    <div class="flex items-center justify-center">
                        <h3 wire:loading.class.delay='opacity-50'
                            @class(['font-semibold dark:group-hover:text-neutral-400 dark:text-neutral-200 text-sm', 'text-gray-800 group-hover:text-skin-base' => ($weekDay != $item->day_of_week), 'text-white group-hover:text-white' => ($weekDay == $item->day_of_week)])>
                            {{ __('app.' . $item->day_of_week) }}
                        </h3>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            @endforeach

        </div>
        <!-- End Card Section -->


        @if ($menuItems)
            <div class="w-full">
                <div class="my-4 flex items-center gap-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ $weekDay}}</h1>
                </div>
            </div>

            <livewire:settings.reservation-day-settings :weekDay='$weekDay' key='week-item-{{ microtime() }}' />

        @endif
    </div>

</div>
