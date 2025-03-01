<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.order.amount')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.order.paymentMethod')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.order.orderNumber')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.dateTime')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='customer-list-{{ microtime() }}'>

                            @forelse ($payments as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='customer-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ currency_format($item->amount) }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white"">
                                    @lang('modules.order.due')
                                </td>

                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="javascript:;" class="underline underline-offset-2 decoration-dotted" wire:click="$dispatch('showOrderDetail', { id: {{ $item->order->id }} })">@lang('modules.order.orderNumber') #{{ $item->order->order_number }}</a>
                                </td>
                                <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->created_at->timezone(timezone())->translatedFormat('d M Y, h:i A') }}
                                </td>
                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right">
                                    <x-secondary-button-table wire:click='showPayment({{ $item->order_id }})'
                                        wire:key='edit-cat-button-{{ $item->id }}'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 mr-1" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                          </svg>
                                        @lang('modules.order.addPayment')
                                    </x-secondary-button-table>

                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6 dark:text-white" colspan="5">
                                    @lang('messages.noPaymentFound')
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div wire:key='payments-table-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 w-full">
            {{ $payments->links() }}
        </div>
    </div>
</div>