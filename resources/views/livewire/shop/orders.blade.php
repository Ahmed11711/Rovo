<div class="px-4">

    <h2 class="text-2xl font-extrabold dark:text-white">@lang('modules.order.myOrders')</h2>

    <ul role="list" class=" space-y-2 dark:divide-gray-700 mt-4">
        @forelse ($orders as $order)
        <li class="p-3 border rounded-md">
            <div class="flex flex-col space-y-4" x-data="{ expanded: false }">

                <div class="flex items-center justify-between cursor-pointer"  x-on:click="expanded = ! expanded">
                    <div class="flex items-center min-w-0">
                        <div>
                            <p class="font-medium text-skin-base truncate dark:text-white">
                                @lang('modules.order.orderNumber') #{{ $order->order_number }}
                            </p>
                            <div class="flex items-center flex-1 text-xs text-gray-500">
                               {{ $order->items->count() }} @lang('modules.menu.item') | {{ $order->date_time->timezone($restaurant->timezone)->translatedFormat('M d, Y H:i A') }}
                            </div>
                        </div>
                    </div>
                    <div class="inline-flex flex-col text-right text-base font-semibold text-gray-900 dark:text-white">
                        <div>{{ currency_format($order->total, $restaurant->currency_id) }}</div>
                        <div class="text-xs text-gray-500 font-light">@lang('modules.order.includeTax')</div>
                    </div>
                </div>

                <div class="flex flex-col space-y-4" x-show="expanded">
                    <!-- Order Items -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($order->items as $key => $item)
                            <div class="p-4" wire:key='menu-item-{{ $key . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <div class="flex items-start space-x-4 rtl:space-x-reverse">
                                    <!-- Item Image -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->menuItem->item_photo_url }}" 
                                             alt="{{ $item->menuItem->item_name }}"
                                             class="w-10 h-10 rounded-md object-cover">
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <!-- Item Header Row -->
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 dark:text-white text-sm lg:text-base">
                                                    {{ $item->menuItem->item_name }}
                                                </h4>
                                                @if(isset($item->menuItemVariation))
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $item->menuItemVariation->variation }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-4 text-xs lg:text-sm rtl:space-x-reverse">
                                                <div class="text-gray-600 dark:text-gray-400  hidden lg:block">
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ $item->quantity }}</span> x
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ currency_format($item->price, $restaurant->currency_id) }}</span>
                                                </div>
                                                <div class="font-semibold text-gray-900 dark:text-white">
                                                    {{ currency_format($item->amount, $restaurant->currency_id) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <span class="text-gray-900 dark:text-white text-xs lg:hidden">@lang('modules.order.qty'): {{ $item->quantity }}</span>

                                            @if ($item->menuItem->preparation_time)
                                            <!-- Preparation Time -->
                                            <div class="flex items-center text-xs lg:text-sm text-gray-500 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                    <span>{{ $item->menuItem->preparation_time }} @lang('modules.menu.minutes')</span>
                                                </div>
                                            @endif
    
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <p class="text-gray-500 dark:text-gray-400">@lang('messages.noItemAdded')</p>
                            </div>
                        @endforelse

                        @foreach ($order->taxes as $item)
                        <div class="flex justify-between items-center py-2 text-xs lg:text-sm text-gray-500 dark:text-gray-400 px-4">
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $item->tax->tax_name }}</span>
                                <span class="ml-1">({{ $item->tax->tax_percent }}%)</span>
                            </div>
                            <div class="font-semibold text-gray-900 dark:text-white">
                                {{ currency_format(($item->tax->tax_percent / 100) * $order->sub_total, $restaurant->currency_id) }}
                            </div>
                        </div>
                        @endforeach

                        <!-- Order Total -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-900 dark:text-white">@lang('modules.order.total')
                                    <span class="text-xs text-gray-500 dark:text-gray-400">@lang('modules.order.includeTax')</span>
                                </span>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ currency_format($order->total, $restaurant->currency_id) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </li>
        @empty
        <li class="p-8 border rounded-md text-center">
            <div class="flex flex-col items-center justify-center space-y-3">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">@lang('messages.noItemAdded')</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">@lang('messages.startShoppingNow')</p>
                <x-primary-link wire:navigate class="inline-flex items-center" href="{{ module_enabled('Subdomain')?url('/'):route('shop_restaurant',['hash' => $restaurant->hash]) }}">
                    @lang('modules.menu.browseMenu')
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </x-primary-link>
            </div>
        </li>
        @endforelse
    </ul>
</div>