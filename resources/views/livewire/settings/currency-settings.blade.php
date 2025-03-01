<div>

    <div class="px-4 mb-4">
        <x-button type='button' wire:click="showAddCurrency" >@lang('modules.settings.addCurrency')</x-button>
    </div>

    <div class="flex flex-col">

        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.restaurantCurrency')
                                </th>

                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.currencySymbol')
                                </th>

                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.currencyFormat')
                                    <br>(Sample: 12345.6789)
                                </th>

                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='member-list-{{ microtime() }}'>

                            @forelse ($currencies as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='member-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->currency_name }}
                                </td>

                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->currency_code }} ({{ $item->currency_symbol }})
                                </td>

                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ currency_format(12345.6789, $item->id) }}
                                </td>

                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right">
                                    <x-secondary-button-table wire:click='showEditCurrency({{ $item->id }})' wire:key='member-edit-{{ $item->id . microtime() }}'
                                        wire:key='editmenu-item-button-{{ $item->id }}'>
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

                                    @if ($item->id != restaurant()->currency_id)
                                    <x-danger-button-table wire:click="showDeleteCurrency({{ $item->id }})"  wire:key='member-del-{{ $item->id . microtime() }}'>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-danger-button-table>
                                    @else
                                        <br><span class="text-xs dark:text-gray-400">@lang('messages.cannotDeleteDefaultCurrency')</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6" colspan="3">
                                    @lang('messages.noCurrencyFound')
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <x-right-modal wire:model.live="showEditCurrencyModal">
        <x-slot name="title">
            {{ __("modules.settings.editCurrency") }}
        </x-slot>

        <x-slot name="content">
            @if ($currency)
            @livewire('forms.editCurrency', ['currency' => $currency], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditCurrencyModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-right-modal wire:model.live="showAddCurrencyModal">
        <x-slot name="title">
            {{ __("modules.settings.addCurrency") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.addCurrency')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showAddCurrencyModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-confirmation-modal wire:model="confirmDeleteCurrencyModal">
        <x-slot name="title">
            @lang('modules.settings.deleteCurrency')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.settings.deleteCurrencyMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteCurrencyModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($currency)
            <x-danger-button class="ml-3" wire:click='deleteCurrency({{ $currency->id }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
         </x-slot>
    </x-confirmation-modal>


</div>
