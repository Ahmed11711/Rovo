<div class="w-full py-6 dark:bg-gray-800">
    <div class="bg-white dark:bg-gray-700 shadow-md border dark:border-gray-600 rounded-lg">
        <!-- Header Section -->
        <div class="border-b border-gray-200 dark:border-gray-600 px-6 py-4 flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 flex items-center">
                <svg class="h-6 w-6 mr-2 text-skin-base" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m8.38 12 2.41 2.42 4.83-4.84" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.75 2.45c.69-.59 1.82-.59 2.52 0l1.58 1.36c.3.26.86.47 1.26.47h1.7c1.06 0 1.93.87 1.93 1.93v1.7c0 .39.21.96.47 1.26l1.36 1.58c.59.69.59 1.82 0 2.52l-1.36 1.58c-.26.3-.47.86-.47 1.26v1.7c0 1.06-.87 1.93-1.93 1.93h-1.7c-.39 0-.96.21-1.26.47l-1.58 1.36c-.69.59-1.82.59-2.52 0l-1.58-1.36c-.3-.26-.86-.47-1.26-.47H6.18c-1.06 0-1.93-.87-1.93-1.93V16.1c0-.39-.21-.95-.46-1.25l-1.35-1.59c-.58-.69-.58-1.81 0-2.5l1.35-1.59c.25-.3.46-.86.46-1.25V6.2c0-1.06.87-1.93 1.93-1.93h1.73c.39 0 .96-.21 1.26-.47z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @lang('modules.billing.offlineRequest')
            </h4>
        </div>

        <div class="overflow-x-auto pt-4 dark:bg-gray-800">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
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
                                    @lang('modules.billing.paymentBy')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.created')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.status')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='invoice-list-{{ microtime() }}'>
                        @forelse ($offlinePaymentRequest as $request)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='request-{{ $request->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $request->package->package_name }} ({{ ucfirst($request->package->package_type->value) }})
                            </td>
                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ucfirst($request->package_type) }}
                            </td>
                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $request->offlineMethod->name }}
                            </td>
                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $request->package->created_at->format('D, d M Y, h:i A') }}
                            </td>
                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($request->status == 'verified')
                                <span class="bg-green-100 uppercase text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">@lang('app.verified')</span>
                                @elseif ($request->status == 'pending')
                                <span class="bg-yellow-100 uppercase text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">@lang('app.pending')</span>
                                @else
                                <span class="bg-red-100 uppercase text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">@lang('app.rejected')</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right dark:text-white">
                                <button wire:click="downloadFile({{ $request->id }})" class="inline-flex self-center items-center p-2 text-sm font-medium border text-center text-gray-900 dark:border-gray-400 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600" type="button">
                                    <svg class="w-5 h-5 text-gray-900 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="24" width="24" viewBox="0 0 20 20"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2m-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/></svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-8 px-4 text-center dark:text-white" colspan="9">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13c-2.8-.8-4.7-1-8-1a1 1 0 0 0-1 1v11c0 .6.5 1 1 1 3.2 0 5 .2 8 1m0-13c2.8-.8 4.7-1 8-1 .6 0 1 .5 1 1v11c0 .6-.5 1-1 1-3.2 0-5 .2-8 1"/>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-500 dark:text-gray-400">
                                        @lang('messages.noOfflinePaymentRequestFound')
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div wire:key='menu-item-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 w-full">
            {{ $offlinePaymentRequest->links() }}
        </div>
    </div>
    </div>
</div>
