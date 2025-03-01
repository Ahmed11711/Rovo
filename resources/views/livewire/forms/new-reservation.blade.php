<div>


    <div class="space-y-6 mt-10">

        <div class="gap-4 grid lg:grid-cols-3">

            <div>
                <x-datepicker  wire:change='loadAvailableTimeSlots' class="w-full" wire:model.live="date" id="date" autocomplete="off" placeholder="{{ __('Select start date') }}" />
            </div>
            
            <div>
                <button wire:key='reservation-date' id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="click" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg text-lg text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 w-full justify-between" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people mr-2" viewBox="0 0 16 16">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                    </svg>
                    
                    {{ $numberOfGuests }} @lang('modules.reservation.guests')
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                    
                <!-- Dropdown menu -->
                <div wire:key='reservation-date-2' id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full dark:bg-gray-700 max-w-60">
                    <ul class="py-2 text-gray-700 dark:text-gray-200 max-h-72 overflow-auto" aria-labelledby="dropdownHoverButton">
                        @for ($i = 1; $i <= 30; $i++)
                        <li>
                            <a href="javascript:;" wire:click="setReservationGuest('{{ $i }}')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-md">{{ $i }} @lang('modules.reservation.guests')</a>
                        </li>
                        @endfor
                    </ul>
                </div>
            </div>
            
            <div>
                <button wire:key='reservation-date-3' id="dropdownHoverButtonMeal" data-dropdown-toggle="dropdownHoverMeal" data-dropdown-trigger="click" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg text-lg text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 w-full justify-between" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock mr-2" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                    </svg>
                    
                    @lang('modules.reservation.' . $slotType)
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                    
                <!-- Dropdown menu -->
                <div wire:key='reservation-date-3' id="dropdownHoverMeal" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full dark:bg-gray-700 max-w-60">
                    <ul class="py-2 text-gray-700 dark:text-gray-200 max-h-72 overflow-auto" aria-labelledby="dropdownHoverButtonMeal">
                        <li>
                            <a href="javascript:;" wire:click="setReservationSlotType('Breakfast')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-md">
                                @lang('modules.reservation.Breakfast')
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" wire:click="setReservationSlotType('Lunch')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-md">
                                @lang('modules.reservation.Lunch')
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" wire:click="setReservationSlotType('Dinner')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-md">
                                @lang('modules.reservation.Dinner')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>

            <h4 class="text-xl font-semibold dark:text-white mt-10">@lang('messages.selectTimeSlot')</h4>
            <div class="mt-2 space-y-2">
                <ul class="grid w-full lg:gap-6 gap-4 lg:grid-cols-6">
                    @foreach ($timeSlots as $timeSlot)
                    <li wire:key='timeSlot.{{ $loop->index }}.{{ microtime() }}'>
                        <input type="radio" id="timeSlot{{ $loop->index }}" wire:model="availableTimeSlots" value="{{ $timeSlot }}" class="hidden peer" />
                        <label for="timeSlot{{ $loop->index }}" class="inline-flex items-center justify-center w-full p-2 text-gray-500 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-skin-base peer-checked:border-skin-base peer-checked:text-skin-base hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
                            <div class="block">
                                <div class="w-full text-md font-medium">{{ \Carbon\Carbon::parse($timeSlot)->translatedFormat('h:i A') }}</div>
                            </div>
                        </label>
                    </li>
                    @endforeach
                </ul>
                @error('availableTimeSlots') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

            </div>

            @if (!empty($timeSlots))
            <div>
                <x-label for="specialRequest" :value="__('app.specialRequest')" />
                <x-textarea class="block mt-1 w-full" wire:model='specialRequest' rows='2' />
                <x-input-error for="specialRequest" class="mt-2" />
            </div>


            <div class="gap-4 grid lg:grid-cols-3">
                       
                <div>
                    <x-label for="customer_name" value="{{ __('modules.customer.name') }}" />
                    <x-input id="customer_name" class="block mt-1 w-full" type="text" name="menu_name" autofocus wire:model='customerName' />
                    <x-input-error for="customerName" class="mt-2" />
                </div>
                <div>
                    <x-label for="customerPhone" value="{{ __('modules.customer.phone') }}" />
                    <x-input id="customerPhone" class="block mt-1 w-full" type="tel" name="customerPhone"  wire:model='customerPhone' />
                    <x-input-error for="customerPhone" class="mt-2" />
                </div>
                <div>
                    <x-label for="customerEmail" value="{{ __('modules.customer.email') }}" />
                    <x-input id="customerEmail" class="block mt-1 w-full" type="email" name="customerEmail"  wire:model='customerEmail' />
                    <x-input-error for="customerEmail" class="mt-2" />
                </div>
            </div>


            <x-button type='button' wire:click='submitReservation'>@lang('app.reserveNow')</x-button>

            @else

            <x-alert type="danger">
                @lang('messages.noTimeSlot')
            </x-alert>

            @endif


    </div>

</div>
