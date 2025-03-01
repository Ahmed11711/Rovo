<div>
    <div
        class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.restaurantInformation')</h3>
        <x-help-text class="mb-6">@lang('modules.settings.generalHelp')</x-help-text>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <form wire:submit="submitForm">
                    <div>
                        <div>
                            <x-label class="mt-4" for="restaurantName"
                                value="{{ __('modules.settings.restaurantName') }}" />
                            <x-input id="restaurantName" class="block mt-2 w-full" type="text"
                                placeholder="{{ __('placeholders.restaurantNamePlaceHolder') }}" autofocus
                                wire:model='restaurantName' />
                            <x-input-error for="restaurantName" class="mt-2" />
                        </div>

                        <div>
                            <x-label class="mt-4" for="restaurantPhoneNumber"
                                value="{{ __('modules.settings.restaurantPhoneNumber') }}" />
                            <x-input id="restaurantPhoneNumber" class="block mt-2 w-full" type="tel"
                                wire:model='restaurantPhoneNumber' />
                            <x-input-error for="restaurantPhoneNumber" class="mt-2" />
                        </div>

                        <div>
                            <x-label class="mt-4" for="restaurantEmailAddress"
                                value="{{ __('modules.settings.restaurantEmailAddress') }}" />
                            <x-input id="restaurantEmailAddress" class="block mt-2 w-full" type="email"
                                wire:model='restaurantEmailAddress' />
                            <x-input-error for="restaurantEmailAddress" class="mt-2" />
                        </div>

                        <div>
                            <x-label class="mt-4" for="restaurantAddress"
                                value="{{ __('modules.settings.restaurantAddress') }}" />
                            <x-textarea class="block mt-2 w-full" wire:model='restaurantAddress' rows='3' />
                            <x-input-error for="restaurantAddress" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-span-2 mt-3">
                        <x-button>@lang('app.save')</x-button>
                    </div>
                </form>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <form wire:submit="submitTax" class="flex flex-col justify-between h-full">
                    <div class="rounded-lg p-4 flex-grow">
                        <div class="space-y-4">
                            <x-label for="showTax">
                                <div class="flex items-center cursor-pointer pb-4">
                                    <x-checkbox name="showTax" id="showTax" wire:model.live="showTax" />
                                    <div class="ms-2">
                                        @lang('modules.settings.showTax')
                                    </div>
                                </div>
                            </x-label>

                            @if ($showTax)

                                @foreach ($taxFields as $index => $field)
                                    <div class="flex items-center gap-x-3 justify-between mb-2"
                                        wire:key="main-{{ $index }}">
                                        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-3"
                                            wire:key="data-{{ $index }}">
                                            <div>
                                                <x-label for="taxName{{ $index }}"
                                                    value=" {{ __('modules.settings.taxName') }}" />
                                                <x-input id="taxName{{ $index }}" class="block mt-1 w-full"
                                                    type="text" required
                                                    wire:model="taxFields.{{ $index }}.taxName" />
                                                <x-input-error for="taxFields.{{ $index }}.taxName"
                                                    class="mt-2" />
                                            </div>
                                            <div>
                                                <x-label for="taxId{{ $index }}"
                                                    value="{{ __('modules.settings.taxId') }}" />
                                                <x-input id="taxId{{ $index }}" class="block mt-1 w-full" required
                                                    type="text" wire:model="taxFields.{{ $index }}.taxId" />
                                                <x-input-error for="taxFields.{{ $index }}.taxId"
                                                    class="mt-2" />
                                            </div>
                                        </div>

                                        <x-secondary-button type="button"
                                            wire:click="showConfirmationField({{ $field['id'] ?? 'null' }}, {{ $index }})"
                                            class="mt-5 p-2 {{ $index > 0 ? 'visible' : 'invisible' }}">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-red-500">
                                                <path d="M10 11V17" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M14 11V17" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M4 7H20" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path
                                                    d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </x-secondary-button>

                                    </div>
                                @endforeach
                                 <x-secondary-button type="button" class="m-2" wire:click="addMoreTaxFields" name="addMore">
                                    @lang('modules.settings.addMore')
                                </x-secondary-button>
                            @else
                                <div class="flex flex-col items-center justify-center p-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-12 h-12 mt-5 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 8.25h15m-15 0V19.5a2.25 2.25 0 002.25 2.25h10.5a2.25 2.25 0 002.25-2.25V8.25m-15 0l1.5-3.75A2.25 2.25 0 019 3.75h6a2.25 2.25 0 012.25 1.5l1.5 3.75M12 11.25v6.75m-3-3h6" />
                                    </svg>
                                    <p class="mt-4 text-lg text-center text-gray-500">
                                        @lang('modules.settings.noTaxFound')
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="flex justify-end mt-4 pt-4">

                        <x-button class="m-2">@lang('app.saveTax')</x-button>
                    </div>
                </form>
            </div>

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4" wire:key='charges-section'>
                @if(!$showChargesForm)
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">@lang('modules.settings.charges')</h3>
                    <x-button type='button' wire:click="showForm">@lang('modules.settings.addCharge')</x-button>
                </div>

                <div class="flex flex-col">

                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow">
                                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                @lang('modules.settings.chargeName')
                                            </th>

                                            <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                @lang('modules.settings.chargeType')
                                            </th>

                                            <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                @lang('modules.settings.rate')
                                            </th>

                                            <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                @lang('modules.settings.orderType')
                                            </th>

                                            <th scope="col" class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                                @lang('app.action')
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='member-list-{{ microtime() }}'>

                                        @forelse ($charges as $item)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='member-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $item->charge_name }}
                                            </td>
                                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $item->charge_type }}
                                            </td>
                                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $item->charge_type == 'percent' ? $item->charge_value . '%' : currency_format($item->charge_value) }}
                                            </td>

                                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($item->order_types as $orderType)
                                                    <div class="inline-flex gap-2 items-center">
                                                        @if ($orderType == 'pickup')
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                                class="bi bi-bag-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z" />
                                                            </svg>
                                                        @elseif($orderType == 'delivery')
                                                            <svg class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                                fill="currentColor" version="1.0" viewBox="0 0 512 512"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <g transform="translate(0 512) scale(.1 -.1)">
                                                                    <path
                                                                        d="m2605 4790c-66-13-155-48-213-82-71-42-178-149-220-221-145-242-112-552 79-761 59-64 61-67 38-73-13-4-60-24-104-46-151-75-295-249-381-462-20-49-38-91-39-93-2-2-19 8-40 22s-54 30-74 36c-59 16-947 12-994-4-120-43-181-143-122-201 32-33 76-33 106 0 41 44 72 55 159 55h80v-135c0-131 1-137 25-160l24-25h231 231l24 25c24 23 25 29 25 161v136l95-4c82-3 97-6 117-26l23-23v-349-349l-46-46-930-6-29 30c-17 16-30 34-30 40 0 7 34 11 95 11 88 0 98 2 120 25 16 15 25 36 25 55s-9 40-25 55c-22 23-32 25-120 25h-95v80 80h55c67 0 105 29 105 80 0 19-9 40-25 55l-24 25h-231-231l-24-25c-33-32-33-78 0-110 22-23 32-25 120-25h95v-80-80h-175c-173 0-176 0-200-25-33-32-33-78 0-110 24-25 27-25 197-25h174l12-45c23-88 85-154 171-183 22-8 112-12 253-12h220l-37-43c-103-119-197-418-211-669-7-115-7-116 19-142 26-25 29-26 164-26h138l16-69c55-226 235-407 464-466 77-20 233-20 310 0 228 59 409 240 463 464l17 71h605 606l13-62c58-281 328-498 621-498 349 0 640 291 640 640 0 237-141 465-350 569-89 43-193 71-271 71h-46l-142 331c-78 183-140 333-139 335 2 1 28-4 58-12 80-21 117-18 145 11l25 24v351 351l-26 26c-24 24-30 25-91 20-130-12-265-105-317-217l-23-49-29 30c-16 17-51 43-79 57-49 26-54 27-208 24-186-3-227 9-300 87-43 46-137 173-137 185 0 3 10 6 23 6s48 12 78 28c61 31 112 91 131 155 7 25 25 53 45 70 79 68 91 152 34 242-17 27-36 65-41 85-13 46-13 100 0 100 6 0 22 11 35 25 30 29 33 82 10 190-61 290-332 508-630 504-38-1-88-5-110-9zm230-165c87-23 168-70 230-136 55-57 108-153 121-216l6-31-153-4c-131-3-161-6-201-25-66-30-133-96-165-162-26-52-28-66-31-210l-4-153-31 6c-63 13-159 66-216 121-66 62-113 143-136 230-88 339 241 668 580 580zm293-619c7-41 28-106 48-147l36-74-24-15c-43-28-68-59-68-85 0-40-26-92-54-110-30-20-127-16-211 8l-50 14-3 175c-2 166-1 176 21 218 35 67 86 90 202 90h91l12-74zm-538-496c132-25 214-88 348-269 101-137 165-199 241-237 31-15 57-29 59-30s-6-20-17-43c-12-22-27-75-33-117-12-74-12-76-38-71-149 30-321 156-424 311-53 80-90 95-140 55-48-38-35-89 52-204l30-39-28-36c-42-54-91-145-110-208l-18-57-337-3-338-2 6 82c9 112 47 272 95 400 135 357 365 522 652 468zm1490-630c0-254 1-252-83-167-54 53-77 104-77 167s23 114 77 168c84 84 83 86 83-168zm-454 63c18-13 41-46 57-83l26-61-45-19c-75-33-165-52-244-54l-75-1-3 29c-8 72 44 166 113 201 42 22 132 16 171-12zm-2346-63v-80h-120-120v80 80h120 120v-80zm1584-184c80-52 154-84 261-111l90-23 112-483c68-295 112-506 112-540 1-68-21-134-56-171l-26-27-17 48c-29 86-99 159-177 186l-38 13-6 279c-5 297-5 297-64 414-58 113-212 233-328 254-21 4-41 14-44 21-12 32 88 201 111 186 6-4 37-24 70-46zm1099-493 185-433-348-490h-138-138l33 68c40 81 56 176 44 252-8 47-203 894-217 941-4 13 9 17 75 23 80 6 230 44 280 71 14 7 29 10 32 7 4-4 90-202 192-439zm-1323 187c118-22 229-99 275-190 37-74 45-138 45-375v-225h-160-160v115c0 179-47 289-158 369-91 67-141 76-417 76h-244l10 32c5 18 9 72 9 120v88h374c209 0 397-4 426-10zm-319-402c50-15 111-67 135-115 16-32 20-70 24-244l5-205 36-72 35-72h-759-759l7 63c17 164 95 400 165 502 47 68 129 124 215 145 52 13 853 12 896-2zm2114-323c256-67 415-329 350-580-48-184-202-326-390-358-197-34-412 76-500 257-19 39-38 86-41 104l-6 32h80 81l24-53c31-69 86-123 156-156 77-36 192-36 266-1 63 31 124 91 156 155 33 68 34 197 2 267-27 60-95 127-156 157-95 46-229 36-311-22-18-12-26-15-21-6 13 22 126 182 143 202 19 22 86 23 167 2zm-1315-243c39-21 87-99 77-125-6-15-27-17-178-17-193 0-231 7-289 58-35 29-70 78-70 97 0 3 96 5 213 5 187 0 217-2 247-18zm1288-89c51-38 67-70 67-133s-16-95-69-134c-43-33-132-29-179 7-20 15-37 32-37 38 0 5 36 9 80 9 73 0 83 3 105 25 33 32 33 78 0 110-22 22-32 25-105 25-44 0-80 4-80 8 0 12 29 37 65 57 39 21 117 15 153-12zm-397-46c-10-9-11-8-5 6 3 10 9 15 12 12s0-11-7-18zm-2460-217c45-106 169-184 289-184s244 78 289 184l22 50h81 81l-7-32c-13-65-66-159-123-219-186-195-500-195-686 0-57 60-110 154-123 219l-6 32h80 81l22-50zm419 41c0-16-51-50-91-63-30-8-48-8-78 0-40 13-91 47-91 63 0 5 57 9 130 9s130-4 130-9z" />
                                                                </g>
                                                            </svg>
                                                        @else
                                                            <svg class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                                fill="currentColor" version="1.0" viewBox="0 0 512 512"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <g transform="translate(0 512) scale(.1 -.1)">
                                                                    <path
                                                                        d="m249 4691c-19-20-29-40-29-60 0-16-14-243-31-503s-28-495-25-522 19-77 35-111c46-100 126-167 236-200l40-12 3-400 2-401-25-6c-58-15-56 21-53-867l3-814 23-45c35-72 75-114 144-151 58-31 70-34 148-34s90 3 148 34c70 38 100 69 140 145l27 51 5 293 5 294 52-64c380-466 1036-731 1654-667 645 65 1211 449 1511 1024l57 110 3-495c3-491 3-495 26-540 35-72 75-114 144-151 58-31 70-34 148-34s90 3 148 34c70 38 100 69 140 145l27 51 3 1938 2 1938-52 52-161-5c-184-6-260-25-384-93-90-50-218-178-268-268-66-120-87-202-93-370l-5-148-86 84c-469 455-1109 646-1736 517-295-61-612-212-835-399l-75-63-6 53c-4 30-15 182-24 339-12 208-21 291-32 308-31 50-98 53-130 6-15-24-15-48 6-387 12-199 24-383 27-409 5-41 3-48-19-62-28-19-159-52-234-60l-53-5v455 455l-25 24c-15 16-36 25-55 25s-40-9-55-25l-25-24v-456-457l-27 6c-16 3-53 8-83 12-69 8-174 40-188 57-7 8-3 125 14 382 30 467 30 450-1 480-33 33-70 32-106-4zm4551-1171v-1040h-320-320v783c0 512 4 804 11 843 29 162 151 321 303 394 91 44 149 57 254 59l72 1v-1040zm-1955 776c271-49 475-131 701-282 126-83 292-236 390-358l64-80v-604-603l25-24c23-24 30-25 150-25 101 0 125-3 125-14 0-34-33-179-60-269-90-288-240-529-465-745-443-426-1063-587-1665-432-403 103-777 372-1019 732l-51 76v382 381l-25 24c-13 14-31 25-40 25-14 0-15 44-13 401l3 402 40 12c111 33 189 100 238 203 29 60 32 77 34 166l1 98 49 50c243 250 626 440 978 487 44 6 94 13 110 15 60 9 352-3 430-18zm-2470-652c200-61 554-55 731 13 15 6 16 1 10-38-9-57-46-112-98-146l-42-28h-256-256l-42 28c-52 34-89 89-98 145-4 23-5 42-3 42s27-7 54-16zm425-764v-400h-80-80v400 400h80 80v-400zm78-1309c-3-739-3-750-24-777-39-53-71-69-134-69s-95 16-134 69c-21 27-21 38-24 777l-2 749h160 160l-2-749zm3920 0c-3-739-3-750-24-777-39-53-71-69-134-69s-95 16-134 69c-21 27-21 38-24 777l-2 749h160 160l-2-749z" />
                                                                    <path
                                                                        d="m2420 3834c-293-38-560-167-763-371-476-475-502-1239-60-1743 495-563 1356-588 1875-52 196 202 313 436 352 703 60 408-69 797-363 1090-182 182-382 293-631 350-83 19-331 33-410 23zm315-169c467-75 826-424 927-900 16-77 16-333 0-410-98-461-436-799-897-897-77-16-333-16-410 0-348 74-626 281-783 580-173 331-175 697-7 1032 214 427 696 672 1170 595z" />
                                                                </g>
                                                            </svg>
                                                        @endif
                                                        @lang('modules.order.' . $orderType)
                                                    </div>
                                                        
                                                    @endforeach
                                                </div>
                                            </td>

                                            <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right">
                                                <x-secondary-button wire:click='showForm({{ $item->id }})'
                                                     wire:key='charge-edit-{{ $item->id . microtime() }}' wire:key='charge-item-button-{{ $item->id }}'>
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                        </path>
                                                        <path fill-rule="evenodd"
                                                             d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                             clip-rule="evenodd"></path>
                                                    </svg>
                                                </x-secondary-button>

                                                <x-danger-button-table wire:click="confirmDeleteCharge({{ $item->id }})"
                                                     wire:key='charge-del-{{ $item->id . microtime() }}'>
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                             d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                             clip-rule="evenodd"></path>
                                                    </svg>
                                                </x-danger-button-table>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 text-center text-gray-500 dark:text-gray-400">
                                            <td class="py-2.5 px-4 space-x-6" colspan="5">
                                                @lang('messages.noChargeFound')
                                            </td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                            <div class="p-2">{{ $charges->links() }}</div>
                        </div>
                    </div>
                    @else
                    @livewire('forms.addCharges', ['selectedChargeId' => $selectedChargeId])
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal wire:model="confirmDeleteChargeModal">
        <x-slot name="title">
            @lang('modules.settings.deleteCharge')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.settings.deleteChargeMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteChargeModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($selectedChargeId)
            <x-danger-button class="ml-3" wire:click='deleteCharge({{ $selectedChargeId }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
        </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal wire:model="confirmDeleteTaxModal">
        <x-slot name="title">
            @lang('modules.settings.deleteTax')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.settings.deleteTaxMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteTaxModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteAndRemove({{ $fieldId }} , {{ $fieldIndex }} )"
                wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
