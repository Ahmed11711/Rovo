<div>
    <div class="flex flex-col">
        <div class="flex gap-4 mb-4">
            <img class="w-16 h-16 rounded-md" src="{{ $menuItem->item_photo_url }}" alt="{{ $menuItem->item_name }}">
            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                <div class="text-base font-semibold text-gray-900 dark:text-white inline-flex items-center">
                    <img src="{{ asset('img/'.$menuItem->type.'.svg')}}" class="h-4 mr-2"
                        title="@lang('modules.menu.' . $menuItem->type)" alt="" />
                    {{ $menuItem->item_name }}
                </div>
                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                    $menuItem->description }}</div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.itemName')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.setPrice')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                            wire:key='menu-item-list-{{ microtime() }}'>

                            @foreach ($menuItem->variations as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                wire:key='menu-item-{{ $item->id . microtime() }}'>
                                <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base text-gray-900 dark:text-white inline-flex items-center">
                                            {{ $item->variation }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->price ? currency_format($item->price) : '--' }}
                                </td>


                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right rtl:space-x-reverse">
                                    <x-secondary-button-table wire:click='editVariation({{ $item->id }})' wire:key='edit-var-btn-{{ $item->id }}'
                                        wire:key='editmenu-item-button-{{ $item->id }}'>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                            </path>
                                            <path fill-rule="evenodd"
                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-secondary-button-table>

                                    <x-danger-button-table wire:click='deleteVariation({{ $item->id }})'  wire:key='del-var-btn-{{ $item->id }}'>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-danger-button-table>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <x-dialog-modal wire:model.live="showDeleteVariationsModal" maxWidth="xl">
        <x-slot name="title">
            @lang('modules.menu.deleteVariant')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.menu.deleteVariantMessage')?
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showDeleteVariationsModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($itemVariation)
            <x-danger-button class="ml-3" wire:click='deleteItemVariation({{ $itemVariation->id }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model.live="showEditVariationsModal" maxWidth="xl">

        <x-slot name="title">
            @lang('modules.menu.itemVariations')
        </x-slot>

        <x-slot name="content">
            @if ($itemVariation)
                <form wire:submit="submitForm">

                    <div class="space-y-4">
                        <div>
                            <x-label for="variationName" value="{{ __('modules.menu.variationName') }}" />
                            <x-input id="variationName" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.itemVariationPlaceholder') }}" name="menu_name" autofocus wire:model='variationName' />
                            <x-input-error for="variationName" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="variationPrice" :value="__('modules.menu.setPrice')" />
                            <div class="relative rounded-md mt-1 flex items-center">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500">{{ currency() }}</span>
                                </div>
                                <x-input id="variationPrice" type="number" step="0.001"
                                    wire:model="variationPrice"
                                    class="block w-full rounded pl-7 text-gray-900 placeholder:text-gray-400"
                                    placeholder="0.00" />

                            </div>
                            <x-input-error for="variationPrice" class="mt-2" />
                        </div>

                    <div class="flex w-full pb-4 space-x-4 mt-6 rtl:space-x-reverse">
                        <x-button>@lang('app.save')</x-button>
                        <x-button-cancel wire:click="$toggle('showEditVariationsModal')" >@lang('app.cancel')</x-button-cancel>
                    </div>
                </form>
            @endif
        </x-slot>

</x-dialog-modal>

</div>
