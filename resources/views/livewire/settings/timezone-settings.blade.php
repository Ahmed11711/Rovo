<div class="grid grid-cols-1 gap-6 mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <div >
        <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.countryTimezone')</h3>

        <form wire:submit="submitForm" class="grid gap-6 grid-cols-1 md:grid-cols-2">
            <div class="grid gap-6 border border-gray-200 dark:border-gray-700 p-4 rounded-lg">

                <div>
                    <x-label for="restaurantCountry" :value="__('modules.settings.restaurantCountry')" />
                    <x-select id="restaurantCountry" class="mt-1 block w-full" wire:model="restaurantCountry">
                        @foreach ($countries as $item)
                        <option value="{{ $item->id }}">{{ $item->countries_name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-label for="restaurantTimezone" :value="__('modules.settings.restaurantTimezone')" />
                    <x-select id="restaurantTimezone" class="mt-1 block w-full" wire:model="restaurantTimezone">
                        @foreach ($timezones as $tz)
                            <option value="{{ $tz }}">{{ $tz }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div>
                    <x-label for="restaurantCurrency" :value="__('modules.settings.restaurantCurrency')" />
                    <x-select id="restaurantCurrency" class="mt-1 block w-full" wire:model="restaurantCurrency">
                        @foreach ($currencies as $item)
                            <option value="{{ $item->id }}">{{ $item->currency_name . ' ('.$item->currency_code.')' }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="border border-gray-200 dark:border-gray-700 p-6 rounded-lg">
                <h3 class="mb-6 text-xl font-semibold dark:text-white">@lang('modules.settings.hideTopNav')</h3>

                <div class="space-y-4">
                    @if (in_array('Order', restaurant_modules()) && user_can('Show Order'))
                    <label class="relative inline-flex items-center p-3 w-full rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <x-checkbox id="hideTodayOrders" wire:model="hideTodayOrders" />
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">@lang('modules.settings.hideTodayOrders')</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">@lang('modules.settings.hideTodayOrdersDescription')</p>
                        </div>
                    </label>
                    @endif

                    @if (in_array('Reservation', restaurant_modules()) && user_can('Show Reservation') && in_array('Table Reservation', restaurant_modules()))
                    <label class="relative inline-flex items-center p-3 w-full rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <x-checkbox id="hideNewReservation" wire:model="hideNewReservation" />
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">@lang('modules.settings.hideNewReservation')</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">@lang('modules.settings.hideNewReservationDescription')</p>
                        </div>
                    </label>
                    @endif

                    @if (in_array('Waiter Request', restaurant_modules()) && user_can('Manage Waiter Request'))
                    <label class="relative inline-flex items-center p-3 w-full rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <x-checkbox id="hideNewWaiterRequest" wire:model="hideNewWaiterRequest" />
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">@lang('modules.settings.hideNewWaiterRequest')</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">@lang('modules.settings.hideNewWaiterRequestDescription')</p>
                        </div>
                    </label>
                    @endif
                </div>
            </div>

            <div class="col-span-1 md:col-span-2">
                <x-button>@lang('app.save')</x-button>
            </div>
        </form>
    </div>

</div>
