<div @class(['flex-col gap-3 items-center border bg-white shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600 p-3 px-1'])>
    <a @class(['group flex flex-col gap-3 items-center '])
       @if ($order->status == 'kot' && !is_null($order->table_id))
           href="{{ route('pos.order', $order->table_id) }}" wire:navigate
       @elseif ($order->status == 'kot' && is_null($order->table_id))
           href="{{ route('pos.kot', $order->id).'?showOrderDetail=true' }}" wire:navigate
       @else
           wire:click="$dispatch('showOrderDetail', { id: {{ $order->id }} })"
       @endif
       wire:key='order-item-{{ $order->id . microtime() }}' href="javascript:;">
        <div class="flex gap-4 justify-between  w-full">
            <div class="flex gap-3 space-y-1">

                <div @class(['p-3 rounded-lg tracking-wide bg-skin-base/[0.2] text-skin-base inline-flex items-center'])>
                    <h3 wire:loading.class.delay='opacity-50'
                        @class(['font-semibold'])>
                        @if ($order->order_type == 'pickup')
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-bag-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z"/>
                            </svg>
                        @elseif($order->order_type == 'delivery')
                            <svg
                                class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                fill="currentColor" version="1.0" viewBox="0 0 512 512"
                                xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(0 512) scale(.1 -.1)">
                                    <path
                                        d="m2605 4790c-66-13-155-48-213-82-71-42-178-149-220-221-145-242-112-552 79-761 59-64 61-67 38-73-13-4-60-24-104-46-151-75-295-249-381-462-20-49-38-91-39-93-2-2-19 8-40 22s-54 30-74 36c-59 16-947 12-994-4-120-43-181-143-122-201 32-33 76-33 106 0 41 44 72 55 159 55h80v-135c0-131 1-137 25-160l24-25h231 231l24 25c24 23 25 29 25 161v136l95-4c82-3 97-6 117-26l23-23v-349-349l-46-46-930-6-29 30c-17 16-30 34-30 40 0 7 34 11 95 11 88 0 98 2 120 25 16 15 25 36 25 55s-9 40-25 55c-22 23-32 25-120 25h-95v80 80h55c67 0 105 29 105 80 0 19-9 40-25 55l-24 25h-231-231l-24-25c-33-32-33-78 0-110 22-23 32-25 120-25h95v-80-80h-175c-173 0-176 0-200-25-33-32-33-78 0-110 24-25 27-25 197-25h174l12-45c23-88 85-154 171-183 22-8 112-12 253-12h220l-37-43c-103-119-197-418-211-669-7-115-7-116 19-142 26-25 29-26 164-26h138l16-69c55-226 235-407 464-466 77-20 233-20 310 0 228 59 409 240 463 464l17 71h605 606l13-62c58-281 328-498 621-498 349 0 640 291 640 640 0 237-141 465-350 569-89 43-193 71-271 71h-46l-142 331c-78 183-140 333-139 335 2 1 28-4 58-12 80-21 117-18 145 11l25 24v351 351l-26 26c-24 24-30 25-91 20-130-12-265-105-317-217l-23-49-29 30c-16 17-51 43-79 57-49 26-54 27-208 24-186-3-227 9-300 87-43 46-137 173-137 185 0 3 10 6 23 6s48 12 78 28c61 31 112 91 131 155 7 25 25 53 45 70 79 68 91 152 34 242-17 27-36 65-41 85-13 46-13 100 0 100 6 0 22 11 35 25 30 29 33 82 10 190-61 290-332 508-630 504-38-1-88-5-110-9zm230-165c87-23 168-70 230-136 55-57 108-153 121-216l6-31-153-4c-131-3-161-6-201-25-66-30-133-96-165-162-26-52-28-66-31-210l-4-153-31 6c-63 13-159 66-216 121-66 62-113 143-136 230-88 339 241 668 580 580zm293-619c7-41 28-106 48-147l36-74-24-15c-43-28-68-59-68-85 0-40-26-92-54-110-30-20-127-16-211 8l-50 14-3 175c-2 166-1 176 21 218 35 67 86 90 202 90h91l12-74zm-538-496c132-25 214-88 348-269 101-137 165-199 241-237 31-15 57-29 59-30s-6-20-17-43c-12-22-27-75-33-117-12-74-12-76-38-71-149 30-321 156-424 311-53 80-90 95-140 55-48-38-35-89 52-204l30-39-28-36c-42-54-91-145-110-208l-18-57-337-3-338-2 6 82c9 112 47 272 95 400 135 357 365 522 652 468zm1490-630c0-254 1-252-83-167-54 53-77 104-77 167s23 114 77 168c84 84 83 86 83-168zm-454 63c18-13 41-46 57-83l26-61-45-19c-75-33-165-52-244-54l-75-1-3 29c-8 72 44 166 113 201 42 22 132 16 171-12zm-2346-63v-80h-120-120v80 80h120 120v-80zm1584-184c80-52 154-84 261-111l90-23 112-483c68-295 112-506 112-540 1-68-21-134-56-171l-26-27-17 48c-29 86-99 159-177 186l-38 13-6 279c-5 297-5 297-64 414-58 113-212 233-328 254-21 4-41 14-44 21-12 32 88 201 111 186 6-4 37-24 70-46zm1099-493 185-433-348-490h-138-138l33 68c40 81 56 176 44 252-8 47-203 894-217 941-4 13 9 17 75 23 80 6 230 44 280 71 14 7 29 10 32 7 4-4 90-202 192-439zm-1323 187c118-22 229-99 275-190 37-74 45-138 45-375v-225h-160-160v115c0 179-47 289-158 369-91 67-141 76-417 76h-244l10 32c5 18 9 72 9 120v88h374c209 0 397-4 426-10zm-319-402c50-15 111-67 135-115 16-32 20-70 24-244l5-205 36-72 35-72h-759-759l7 63c17 164 95 400 165 502 47 68 129 124 215 145 52 13 853 12 896-2zm2114-323c256-67 415-329 350-580-48-184-202-326-390-358-197-34-412 76-500 257-19 39-38 86-41 104l-6 32h80 81l24-53c31-69 86-123 156-156 77-36 192-36 266-1 63 31 124 91 156 155 33 68 34 197 2 267-27 60-95 127-156 157-95 46-229 36-311-22-18-12-26-15-21-6 13 22 126 182 143 202 19 22 86 23 167 2zm-1315-243c39-21 87-99 77-125-6-15-27-17-178-17-193 0-231 7-289 58-35 29-70 78-70 97 0 3 96 5 213 5 187 0 217-2 247-18zm1288-89c51-38 67-70 67-133s-16-95-69-134c-43-33-132-29-179 7-20 15-37 32-37 38 0 5 36 9 80 9 73 0 83 3 105 25 33 32 33 78 0 110-22 22-32 25-105 25-44 0-80 4-80 8 0 12 29 37 65 57 39 21 117 15 153-12zm-397-46c-10-9-11-8-5 6 3 10 9 15 12 12s0-11-7-18zm-2460-217c45-106 169-184 289-184s244 78 289 184l22 50h81 81l-7-32c-13-65-66-159-123-219-186-195-500-195-686 0-57 60-110 154-123 219l-6 32h80 81l22-50zm419 41c0-16-51-50-91-63-30-8-48-8-78 0-40 13-91 47-91 63 0 5 57 9 130 9s130-4 130-9z"/>
                                </g>
                            </svg>
                        @else
                            {{ $order->table->table_code ?? '--' }}
                        @endif
                    </h3>
                </div>

                <div>
                    <div
                        class="font-semibold text-gray-700 truncate max-w-32 text-sm dark:text-gray-300">{{ $order->customer->name ?? '--' }}</div>
                    <div class="font-medium text-gray-600 text-sm dark:text-gray-400">@lang('modules.order.orderNumber')
                        #{{ $order->order_number }}</div>
                </div>
            </div>
            <div class="ltr:text-right rtl:text-left">
                <div>
                    <span @class(['text-xs font-medium px-2 py-1 rounded uppercase tracking-wide whitespace-nowrap ',
                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400 border border-gray-400' => ($order->status == 'draft'),
                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-400 border border-yellow-400' => ($order->status == 'kot'),
                    'bg-blue-100 text-blue-800 dark:bg-gray-700 dark:text-blue-400 border border-blue-400' => ($order->status == 'billed' || $order->status == 'out_for_delivery'),
                    'bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-400 border border-green-400' => ($order->status == 'paid' || $order->status == 'delivered'),
                    'bg-red-100 text-red-800 dark:bg-gray-700 dark:text-red-400 border border-red-400' => ($order->status == 'canceled'|| $order->status == 'payment_due'),
                    ])>
                        @lang('modules.order.' . $order->status)
                    </span>
                </div>

                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 inline-flex gap-1 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor"
                         @class(['text-yellow-300' => ($order->status == 'kot'),
                         'text-gray-500' => ($order->status == 'draft'),
                         'text-blue-500' => ($order->status == 'billed' || $order->status == 'out_for_delivery'),
                         'text-green-500' => ($order->status == 'paid' || $order->status == 'delivered'),
                         'text-red-500' => ($order->status == 'canceled' || $order->status == 'payment_due'),
                         ]) viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8"/>
                    </svg>
                    @lang('modules.order.info' . $order->status)
                </div>

            </div>
        </div>

        <div class="flex w-full justify-between items-center">
            <div class="text-xs text-gray-600 dark:text-gray-400">
                {{ $order->date_time->timezone(timezone())->translatedFormat('F d, Y H:i A') }}
            </div>
            <div class="text-sm font-medium text-gray-800 dark:text-gray-400">
                @if ($order->status == 'kot')
                    {{ $order->kot->count() }} @lang('modules.order.kot')
                @else
                    {{ $order->items->count() }} @lang('modules.menu.item')
                @endif
            </div>
        </div>

        <div class="flex w-full justify-between items-center border-t pt-3">
            <div class="inline-flex gap-1 items-center">
                <div class="text-lg font-medium text-gray-800 dark:text-gray-300">
                    {{ currency_format($order->total) }}
                </div>

            </div>

            @if ($order->status == 'kot' && user_can('Create Order'))
            <div>
                <x-secondary-link href="{{ route('pos.kot', ['id' => $order->id]) }}" class="text-xs">@lang('modules.order.newKot')</x-secondary-link>
            </div>
            @endif

            @if ($order->waiter)
            <div class="inline-flex items-center text-gray-600 text-sm gap-1 dark:text-gray-400">
                <svg width="16" height="16" fill="currentColor" viewBox="0 -2.89 122.88 122.88" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="enable-background:new 0 0 122.88 117.09" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style> <g> <path class="st0" d="M36.82,107.86L35.65,78.4l13.25-0.53c5.66,0.78,11.39,3.61,17.15,6.92l10.29-0.41c4.67,0.1,7.3,4.72,2.89,8 c-3.5,2.79-8.27,2.83-13.17,2.58c-3.37-0.03-3.34,4.5,0.17,4.37c1.22,0.05,2.54-0.29,3.69-0.34c6.09-0.25,11.06-1.61,13.94-6.55 l1.4-3.66l15.01-8.2c7.56-2.83,12.65,4.3,7.23,10.1c-10.77,8.51-21.2,16.27-32.62,22.09c-8.24,5.47-16.7,5.64-25.34,1.01 L36.82,107.86L36.82,107.86z M29.74,62.97h91.9c0.68,0,1.24,0.57,1.24,1.24v5.41c0,0.67-0.56,1.24-1.24,1.24h-91.9 c-0.68,0-1.24-0.56-1.24-1.24v-5.41C28.5,63.53,29.06,62.97,29.74,62.97L29.74,62.97z M79.26,11.23 c25.16,2.01,46.35,23.16,43.22,48.06l-93.57,0C25.82,34.23,47.09,13.05,72.43,11.2V7.14l-4,0c-0.7,0-1.28-0.58-1.28-1.28V1.28 c0-0.7,0.57-1.28,1.28-1.28h14.72c0.7,0,1.28,0.58,1.28,1.28v4.58c0,0.7-0.58,1.28-1.28,1.28h-3.89L79.26,11.23L79.26,11.23 L79.26,11.23z M0,77.39l31.55-1.66l1.4,35.25L1.4,112.63L0,77.39L0,77.39z"></path> </g> </g></svg>

                {{ $order->waiter->name ?? '--' }}
            </div>
            @endif

        </div>
    </a>
</div>
