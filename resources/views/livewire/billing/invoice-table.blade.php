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
                                    @lang('app.id')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.restaurant')
                                </th>
                                <th scope="col"
                                class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.packageDetails')
                                </th>
                                <th scope="col"
                                class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.billingCycle')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.paymentDate')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.nextPaymentDate')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.transactionId')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.paymentGateway')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.amount')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='invoice-list-{{ microtime() }}'>
                        @forelse ($invoices as $invoice)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='invoice-{{ $invoice->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->id }}
                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ route('superadmin.restaurants.show', $invoice->restaurant->hash) }}" class="underline underline-offset-1 font-medium" wire:navigate>{{ $invoice->restaurant->name }}</a>
                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->package->package_name }}<br>
                                @if ($invoice->package->package_type->value == 'trial')
                                <span class="bg-amber-500 text-white inline-flex text-xs font-medium items-center px-1 rounded gap-x-0.5 dark:bg-amber-600 border border-amber-500">
                                    <svg class="w-2.5 h-2.5 me-0.5 text-current" aria-hidden="true" height="16px" width="16px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.01 10.01 0 0 0 10 0m3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1 1 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414"/></svg>
                                    @lang('modules.package.trial')
                                </span>
                                @elseif($invoice->package->package_type->value == 'lifetime')
                                <span class="bg-indigo-500 text-white inline-flex text-xs font-medium items-center px-1 rounded gap-x-0.5 dark:bg-indigo-600 border border-indigo-500">
                                    <svg class="w-3 h-3 text-current" width="24" height="24" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"/><g stroke-linecap="round" stroke-linejoin="round"/><path d="m31.89 14.55-4-8A1 1 0 0 0 27 6H5a1 1 0 0 0-.89.55l-4 8a.3.3 0 0 1 0 .09 2 2 0 0 0 0 .26S0 15 0 15v.05a1.3 1.3 0 0 0 .06.28s0 .05 0 .08a.8.8 0 0 0 .18.27l15 16a1 1 0 0 0 1.46 0l15-16a1 1 0 0 0 .19-1.13M16 8.89 19.2 14h-6.4Zm-5.08 4.34L7 8h7.2ZM17.8 8H25l-3.92 5.23Zm1.84 8L16 27.65 12.36 16Zm-5.89 11.14L3.31 16h7Zm8-11.14h7l-10.5 11.14Zm7.65-2H23l3.83-5.11ZM5.17 8.89 9 14H2.62ZM16 4a1 1 0 0 0 1-1V1a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1m-5.71-.29a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-1-1a1 1 0 0 0-1.42 1.42ZM21 4a1 1 0 0 0 .71-.29l1-1a1 1 0 1 0-1.42-1.42l-1 1a1 1 0 0 0 0 1.42A1 1 0 0 0 21 4" data-name="6. Diamond"/></svg>
                                    @lang('modules.package.lifetime')
                                </span>
                                @endif


                            </div>

                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ucfirst($invoice->package_type) }}
                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->pay_date ? $invoice->pay_date->format('D, d M Y') : '--' }}
                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->next_pay_date ? $invoice->next_pay_date->format('D, d M Y') : '--' }}
                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->transaction_id }}
                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->gateway_name }}
                            </td>
                            <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->total ? $invoice->currency->currency_symbol . $invoice->total : '-' }}
                            </td>
                            <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right dark:text-white">
                                <x-secondary-button-table wire:click="downloadReceipt({{$invoice->id}})">
                                        <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0M17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2z" clip-rule="evenodd"/></svg>
                                </x-secondary-button-table>
                            </td>
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2.5 px-4 space-x-6 dark:text-white" colspan="10">
                                @lang('messages.noInvoiceFound')
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div wire:key='invoices-table-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 w-full">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
