<div class="lg:w-5/12 flex flex-col bg-white border-l dark:border-gray-700 min-h-screen h-auto pr-4 px-2 py-4 dark:bg-gray-800">
    <div>
        <h2 class="text-lg  dark:text-neutral-200">@lang('modules.order.orderNumber') #{{ $orderDetail->order_number }}</h2>
        <div class="flex gap-3 space-y-1 my-4 justify-between">
            <div class="inline-flex gap-4">
                <div @class(['p-3 rounded-lg tracking-wide bg-skin-base/[0.2] text-skin-base'])>
                    <h3 wire:loading.class.delay='opacity-50'
                        @class(['font-semibold'])>
                        {{ $orderDetail->table->table_code ?? '--' }}
                    </h3>
                </div>
                <div>
                    @if ($orderDetail->customer_id)
                        <div class="font-semibold text-gray-700 dark:text-gray-300">{{ $orderDetail->customer->name }}</div>
                    @else
                     <a href="javascript:;" wire:click="$dispatch('showAddCustomerModal', { id: {{ $orderDetail->id }} })"
                      class="underline text-sm underline-offset-2">&plus; @lang('modules.order.addCustomerDetails')</a>
                    @endif
                    <div class="font-medium text-gray-600 text-xs dark:text-gray-400">{{ $orderDetail->date_time->translatedFormat('F d, Y H:i A') }}</div>
                </div>

            </div>
            <div>
                <span @class(['text-sm font-medium px-2 py-1 rounded uppercase tracking-wide whitespace-nowrap ',
                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400 border border-gray-400' => ($orderDetail->status == 'draft'),
                'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-400 border border-yellow-400' => ($orderDetail->status == 'kot'),
                'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-400 border border-blue-400' => ($orderDetail->status == 'billed'),
                'bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-400 border border-green-400' => ($orderDetail->status == 'paid'),
                'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-400 border border-red-400' => ($orderDetail->status == 'canceled'),
                ])>
                    @lang('modules.order.' . $orderDetail->status)
                </span>
            </div>
        </div>

        @if ($orderDetail)
        <div class="flex flex-col rounded ">
            <table class=" flex-1  min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            @lang('modules.menu.itemName')
                        </th>
                        <th scope="col"
                            class="p-2 text-xs text-center text-gray-500 uppercase dark:text-gray-400">
                            @lang('modules.order.qty')
                        </th>
                        <th scope="col"
                            class="p-2 text-xs font-medium text-right text-gray-500 uppercase dark:text-gray-400">
                            @lang('modules.order.price')
                        </th>
                        <th scope="col"
                            class="p-2 text-xs font-medium text-right text-gray-500 uppercase dark:text-gray-400">
                            @lang('modules.order.amount')
                        </th>
                        @if (user_can('Delete Order'))
                        <th scope="col"
                            class="p-2 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                            @lang('app.action')
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='menu-item-list-{{ microtime() }}'>

                    @forelse ($orderDetail->items->load('modifierOptions') as $key => $item)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='menu-item-{{ $key . microtime() }}' wire:loading.class.delay='opacity-10'>
                        <td class="flex flex-col p-2 mr-12 lg:min-w-28">
                            <div class="text-xs text-gray-900 dark:text-white inline-flex items-center">
                                {{ $item->menuItem->item_name }}
                            </div>
                            @if (isset($item->menuItemVariation))
                            <div class="text-xs text-gray-600 dark:text-white inline-flex items-center">
                                {{ $item->menuItemVariation->variation }}
                            </div>
                            @endif
                            @if ($item->modifierOptions->isNotEmpty())
                                <div class="text-xs text-gray-600 dark:text-white mt-1">
                                    @foreach ($item->modifierOptions as $modifier)
                                        <div class="flex items-center justify-between text-xs mb-1 py-0.5 px-1 border-l-2 border-blue-500 bg-gray-200 dark:bg-gray-900 rounded-md">
                                            <span class="text-gray-900 dark:text-white">{{ $modifier->name }}</span>
                                            <span class="text-gray-600 dark:text-gray-300">{{ currency_format($modifier->price) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="p-2 text-base text-gray-900 dark:text-gray-200 whitespace-nowrap text-center">
                            {{ $item->quantity }}
                        </td>

                        <td class="p-2 text-xs font-medium text-gray-700 whitespace-nowrap dark:text-white text-right">
                            {{ currency_format($item->price) }}
                        </td>
                        <td class="p-2 text-xs font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                            {{ currency_format($item->amount + $item->modifierOptions->sum('price')) }}
                        </td>
                        @if (user_can('Delete Order'))
                        <td class="p-2 whitespace-nowrap text-right">
                            <button class="rounded text-gray-700 border p-2 dark:text-gray-300" wire:click="deleteOrderItems('{{ $item->id }}')">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="p-2 space-x-6" colspan="5">
                            @lang('messages.noItemAdded')
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div>
            <div class="h-auto p-4 mt-3 select-none text-center w-full bg-gray-50 rounded space-y-4 dark:bg-gray-700">
                <div class="flex justify-between text-gray-500 text-sm dark:text-neutral-400">
                    <div>
                        @lang('modules.order.totalItem')
                    </div>
                    <div>
                        {{ count($orderDetail->items) }}
                    </div>
                </div>
                <div class="flex justify-between text-gray-500 text-sm dark:text-neutral-400">
                    <div>
                        @lang('modules.order.subTotal')
                    </div>
                    <div>
                        {{ currency_format($orderDetail->sub_total, restaurant()->currency_id) }}
                    </div>
                </div>

                @if (!is_null($orderDetail->discount_amount))
                <div wire:key="discountAmount" class="flex justify-between text-green-500 text-sm dark:text-green-400">
                    <div>
                        @lang('modules.order.discount') @if ($orderDetail->discount_type == 'percent') ({{ rtrim(rtrim($orderDetail->discount_value), '.') }}%) @endif
                    </div>
                    <div>
                        -{{ currency_format($orderDetail->discount_amount, restaurant()->currency_id) }}
                    </div>
                </div>
                @endif

                @foreach ($orderDetail->charges as $item)
                    <div class="flex justify-between text-gray-500 text-sm dark:text-gray-400">
                        <div>
                            {{ $item->charge->charge_name }}
                            @if ($item->charge->charge_type == 'percent') 
                                ({{ $item->charge->charge_value }}%)
                            @endif
                        </div>
                        <div>
                            @if ($item->charge->charge_type == 'percent')
                                {{ currency_format(($item->charge->charge_value / 100) * ($order->sub_total - ($order->discount_amount ?? 0))) }}
                            @else
                                {{ currency_format($item->charge->charge_value) }}
                            @endif
                        </div>
                    </div>
                @endforeach

                @foreach ($orderDetail->taxes as $item)
                <div class="flex justify-between text-gray-500 text-sm dark:text-neutral-400">
                    <div>
                        {{ $item->tax->tax_name }} ({{ $item->tax->tax_percent }}%)
                    </div>
                    <div>
                        {{ currency_format(($item->tax->tax_percent / 100) * ($orderDetail->sub_total - ($orderDetail->discount_amount ?? 0)), restaurant()->currency_id) }}
                    </div>
                </div>
                @endforeach

                <div class="flex justify-between font-medium dark:text-neutral-300">
                    <div>
                        @lang('modules.order.total')
                    </div>
                    <div>
                        {{ currency_format($orderDetail->total, restaurant()->currency_id) }}
                    </div>
                </div>
            </div>

            <div class="h-auto pb-4 pt-3 select-none text-center w-full">
                <div class="flex gap-2">

                    @if ($orderDetail->status == 'billed')
                    <button class="rounded bg-green-600 text-white  w-full p-2" wire:click='showPayment({{ $orderDetail->id }})'>
                        @lang('modules.order.addPayment')
                    </button>
                    @endif

                </div>
            </div>
        </div>
        @endif

    </div>

</div>
