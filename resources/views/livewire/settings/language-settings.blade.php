<div class="px-4 my-4">

    <div class="mb-4 flex gap-2">
        <x-button type='button' wire:click="$set('showAddLanguage', true)" >@lang('modules.language.addLanguage')</x-button>

        <x-secondary-link href="{{ url('/translations') }}" target="_blank" >
            @lang('modules.settings.manageTranslations')
        </x-secondary-link>
    </div>

    <form wire:submit="submitForm">

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.language.languageCode')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.language.languageName')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        @lang('modules.language.active')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-left">
                                        @lang('modules.language.rtl')
                                    </th>
                                    <th scope="col"
                                        class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                        @lang('app.action')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                                wire:key='menu-item-list-{{ microtime() }}'>

                                @foreach ($languageSettings as $key => $item)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                    wire:key='menu-item-{{ $item->id . microtime() }}'
                                    wire:loading.class.delay='opacity-10'>
                                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white flex items-center gap-2">
                                        <img class="h-4 w-4 rounded-full border border-gray-200" src="{{ $item->flagUrl }}" alt="">
                                        {{ $item->language_code }}
                                    </td>
                                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->language_name }}
                                    </td>

                                    @if ($item->language_code != global_setting()->locale)  
                                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                        <x-checkbox name="languageActive.{{ $key }}"
                                            id="languageActive.{{ $key }}"
                                            wire:model='languageActive.{{ $key }}' />
                                    </td>
                                    @else
                                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white text-sm">
                                        @lang('modules.language.defaultLanguage')
                                    </td>
                                    @endif

                                    <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-left">
                                        <x-checkbox name="languageRtl.{{ $key }}"
                                            id="languageRtl.{{ $key }}"
                                            wire:model='languageRtl.{{ $key }}' />
                                    </td>

                                    @if ($item->language_code != global_setting()->locale)  
                                    <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right">
                                        <x-secondary-button-table wire:click='showEditLanguage({{ $item->id }})' wire:key='member-edit-{{ $item->id . microtime() }}'
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
    
                                        <x-danger-button-table wire:click="showDeleteLanguage({{ $item->id }})"  wire:key='member-del-{{ $item->id . microtime() }}'>
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </x-danger-button-table>
    
                                    </td>
                                    @else
                                    <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right text-sm">
                                        @lang('modules.language.defaultLanguage')
                                    </td>
                                    @endif
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                    <div class="mt-2">
                        <x-button>@lang('app.save')</x-button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <x-right-modal wire:model.live="showAddLanguage">
        <x-slot name="title">
            {{ __("modules.language.addLanguage") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.addLanguage')
        </x-slot>
    </x-right-modal>

    @if ($showEditLanguageModal)        
    <x-right-modal wire:model.live="showEditLanguageModal">
        <x-slot name="title">
            {{ __("modules.language.editLanguage") }}
        </x-slot>

        <x-slot name="content">
            @livewire('forms.editLanguage', ['language' => $language])
        </x-slot>
    </x-right-modal>
    @endif

    <x-confirmation-modal wire:model="confirmDeleteLanguageModal">
        <x-slot name="title">
            @lang('modules.language.deleteLanguage')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.language.deleteLanguageMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteLanguageModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($language)
            <x-danger-button class="ml-3" wire:click='deleteLanguage({{ $language->id }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
         </x-slot>
    </x-confirmation-modal>


</div>