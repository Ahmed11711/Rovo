<div>
    <x-button  class="mt-4" wire:click="addOfflinePayMethod" wire:loading.attr="disabled">@lang('modules.billing.addPaymentMethod')</x-button>

    <div class="py-4">
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
                                        @lang('modules.billing.name')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.billing.description')
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
                            @forelse ($methods as $method)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='method-{{ $method->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $method->id }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $method->name }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{str($method->description)->limit(100) }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($method->status == 'active')
                                    <span class="bg-green-100 uppercase text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">@lang('app.active')</span>
                                    @else
                                    <span class="bg-red-100 uppercase text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">@lang('app.inactive')</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right dark:text-white">
                                    <x-secondary-button-table wire:click='editPaymentMethod({{ $method->id }})' wire:key='payment-method-edit-{{ $method->id . microtime() }}'>
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                            </path>
                                            <path fill-rule="evenodd"
                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        @lang('app.update')
                                    </x-secondary-button-table>

                                    <x-danger-button-table wire:click="confirmDelete({{ $method->id }})" wire:key='payment-method-del-{{ $method->id . microtime() }}'>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-danger-button-table>
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6 dark:text-white" colspan="5">
                                    @lang('messages.noOfflinePaymentMethodFound')
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
                {{ $methods->links() }}
            </div>
        </div>
    </div>


    <x-dialog-modal wire:model.live="showPaymentMethodForm">
        <x-slot name="title">
            {{ $methodId ? __('app.update') : __('app.add') }} @lang('modules.billing.offlinePaymentMethod')
        </x-slot>

        <x-slot name="content">
            @if ($showPaymentMethodForm)
                <form wire:submit="submitForm">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <x-label for="name" value="{{ __('modules.billing.name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.methodExamples') }}" autofocus wire:model='name' />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="description" value="{{ __('modules.billing.description') }}" />
                            <x-textarea id="description" class="block mt-1 w-full" placeholder="{{ __('placeholders.methodDescription') }}" data-gramm="false"  name="description" wire:model='description' />
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        @if ($methodId)
                            <div>
                                <x-label for="status" value="{{ __('app.status') }}"/>
                                <x-select id="status" class="mt-1 block w-full" wire:model="status">
                                    <option value="active">{{ __('app.active') }}</option>
                                    <option value="inactive">{{ __('app.inactive') }}</option>
                                </x-select>
                                <x-input-error for="status" class="mt-2"/>
                            </div>
                        @endif


                    <div class="flex w-full pb-4 space-x-4 mt-6">
                        <x-button type="submit" wire:target="submitForm" wire:loading.attr="disabled">
                            {{ $methodId ? __('app.update') : __('app.add') }}
                        </x-button>
                        <x-button-cancel wire:click="$toggle('showPaymentMethodForm')">
                            @lang('app.cancel')
                        </x-button-cancel>
                    </div>
                </form>
            @endif
        </x-slot>
    </x-dialog-modal>


    <x-confirmation-modal wire:model="confirmDeleteModal">
        <x-slot name="title">
            @lang('modules.billing.deleteOfflinePaymentMethod')
        </x-slot>

        <x-slot name="content">
            @lang('modules.billing.askDeleteOfflinePaymentMethod')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($deleteId)
            <x-danger-button class="ml-3" wire:click='delete({{ $deleteId }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
         </x-slot>
    </x-confirmation-modal>

</div>
