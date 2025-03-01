<div>
    @assets
    <script src="{{ asset('vendor/pikaday.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/pikaday.css') }}">
    @endassets

    <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.offlineRequest')</h1>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div>
            <div class="md:inline-block min-w-full align-middle">
                <div class="shadow overflow-x-auto h-screen md:h-auto md:overflow-x-visible">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.id')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.restaurant')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.packageDetails')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.billingCycle')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.paymentBy')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.billing.created')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.status')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='invoice-list-{{ microtime() }}'>
                        @forelse ($offlinePaymentRequest as $request)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='request-{{ $request->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $request->id }}
                            </td>
                            <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $request->restaurant->name }}
                            </td>
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
                                <x-dropdown align="right">
                                    <x-slot name="trigger">
                                        <button type="button" class="inline-flex items-center uppercase px-3 py-2 border dark:border-gray-400 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                            <span>@lang('app.action')</span>
                                            <svg class="w-2.5 h-2.5 ms-1" height="24" width="24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        @if ($request->status == 'pending')
                                        <x-dropdown-link wire:click="confirmChangePlan({{ $request->id }}, 'verified')" class="text-green-500 dark:text-green-400">
                                            @lang('app.accept')
                                        </x-dropdown-link>

                                        <x-dropdown-link wire:click="confirmChangePlan({{ $request->id }}, 'rejected')" class="text-red-600 dark:text-red-400">
                                            @lang('app.decline')
                                        </x-dropdown-link>
                                        @endif

                                        <x-dropdown-link wire:click="ViewRequest('{{ $request->id }}')">
                                            @lang('app.view')
                                        </x-dropdown-link>

                                        <x-dropdown-link wire:click="downloadFile({{ $request->id }})">
                                            @lang('app.download')
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </td>
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2.5 px-4 space-x-6 dark:text-white" colspan="9">
                                @lang('messages.noOfflinePaymentRequestFound')
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
            {{ $offlinePaymentRequest->links() }}
        </div>
    </div>

    <x-right-modal wire:model.live="showViewRequestModal">
        <x-slot name="title">
            {{ __('modules.billing.viewPaymentMethod') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-md">
                @if ($showViewRequestModal && $selectViewRequest)
                    <!-- Restaurant Name -->
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.restaurant')</span>
                        <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $selectViewRequest->restaurant->name }}</span>
                    </div>

                    <!-- Package -->
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.package')</span>
                        <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $selectViewRequest->package->package_type }}</span>
                    </div>

                    <!-- Amount -->
                    @if ($selectViewRequest->amount)
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.amount')</span>
                        <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $selectViewRequest->amount }}</span>
                    </div>
                    @endif

                    @if ($selectViewRequest->restaurant->ownerName)
                    <!-- Payment By -->
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.paymentBy')</span>
                        <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $selectViewRequest->restaurant->ownerName }}</span>
                    </div>
                    @endif

                    <!-- Status -->
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('app.status')</span>
                        <span class="text-sm">
                            @if ($selectViewRequest->status == 'verified')
                                <span class="bg-green-100 uppercase text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    @lang('app.verified')
                                </span>
                            @elseif ($selectViewRequest->status == 'pending')
                                <span class="bg-yellow-100 uppercase text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                    @lang('app.pending')
                                </span>
                            @else
                                <span class="bg-red-100 uppercase text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                    @lang('app.rejected')
                                </span>
                            @endif
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.description')</span>
                        <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $selectViewRequest->description }}</span>
                    </div>

                    @if ($selectViewRequest->status == 'rejected')
                        <!-- Remark -->
                        <div class="flex flex-col col-span-2">
                            <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.remark')</span>
                            <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $selectViewRequest->remark }}</span>
                        </div>
                    @endif

                    <!-- Created -->
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.created')</span>
                        <span class="text-sm text-gray-800 dark:text-neutral-200">{{ $selectViewRequest->created_at->format('D, d M Y') }}</span>
                    </div>

                    <!-- Receipt -->
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">@lang('modules.billing.receipt')</span>
                        <a href="javascript:;" wire:click="downloadFile({{ $selectViewRequest->id }})" class="text-sm text-blue-500 hover:underline">
                            @lang('app.download')
                        </a>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showViewRequestModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>


    <x-dialog-modal wire:model="showConfirmChangeModal">
        <x-slot name="title">
            @if ($status == 'verified')
            @lang('modules.billing.acceptOfflineRequest')
            @elseif ($status == 'rejected')
            @lang('modules.billing.rejectOfflineRequest')
            @endif
        </x-slot>

        <x-slot name="content">
            <div class="w-full col-span-2">
                @if ($status == 'verified')
                    <x-label for="payDate" :value="__('modules.billing.paymentDate')" />
                    <x-datepicker id="payDate" class="w-full mt-1" wire:model="payDate" autocomplete="off" placeholder="{{ __('Select Date') }}" />
                    <x-input-error for="payDate" class="mt-2" />

                    <x-label for="nextPayDate" :value="__('modules.billing.nextPaymentDate')" class="mt-4" />
                    <x-datepicker id="nextPayDate" class="w-full mt-1" wire:model="nextPayDate" autocomplete="off" placeholder="{{ __('Select Date') }}" />
                    <x-input-error for="nextPayDate" class="mt-2" />
                @elseif ($status == 'rejected')
                    <x-label for="remark" :value="__('modules.billing.remark')" />
                    <x-textarea data-gramm="false" class="block mt-1 w-full" wire:model='remark' rows='4' />
                    <x-input-error for="remark" class="mt-2" />
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showConfirmChangeModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="changePlan" wire:loading.attr="disabled">
                @lang('app.submit')
            </x-button>
        </x-slot>
    </x-dialog-modal>

</div>

