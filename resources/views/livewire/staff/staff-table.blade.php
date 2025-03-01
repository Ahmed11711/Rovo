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
                                    @lang('modules.staff.name')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.customer.email')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.role')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='member-list-{{ microtime() }}'>

                            @forelse ($members as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='member-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->name }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->email ?? '--' }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($item->id == auth()->id())
                                        <span class="text-xs">@lang('messages.cannotEditOwnRole')</span>
                                    @elseif(user_can('Update Staff Member'))
                                        <button wire:key='member-role-{{ $item->id . microtime() }}' id="dropdownHoverButton{{ $item->id }}" data-dropdown-toggle="dropdownHover{{ $item->id }}" data-dropdown-trigger="click" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150" type="button">
                                            {{ __('modules.staff.'.$item->roles->pluck('display_name')[0]) }}
                                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                            </svg>
                                        </button>
                                            
                                        <!-- Dropdown menu -->
                                        <div wire:key='member-role-{{ $item->id . microtime() }}' id="dropdownHover{{ $item->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton{{ $item->id }}">
                                                @foreach ($roles as $role)
                                                <li>
                                                    <a href="javascript:;" wire:click="setUserRole('{{ $role->name }}', {{ $item->id }})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('modules.staff.'.$role->display_name) }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>                                        
                                    @else
                                    {{ __('modules.staff.'.$item->roles->pluck('display_name')[0]) }}
                                    @endif
                                </td>

                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right rtl:space-x-reverse">
                                    @if(user_can('Update Staff Member'))
                                    <x-secondary-button-table wire:click='showEditCustomer({{ $item->id }})' wire:key='member-edit-{{ $item->id . microtime() }}'
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
                                    @endif

                                    @if(user_can('Delete Staff Member') && $item->id != user()->id)
                                    <x-danger-button-table wire:click="showDeleteCustomer({{ $item->id }})"  wire:key='member-del-{{ $item->id . microtime() }}'>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </x-danger-button-table>
                                    @endif

                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6" colspan="5">
                                    @lang('messages.noMemberFound')
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div wire:key='customer-table-paginate-{{ microtime() }}'
        class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0 w-full">
            {{ $members->links() }}
        </div>
    </div>

    <x-right-modal wire:model.live="showEditCustomerModal">
        <x-slot name="title">
            {{ __("modules.staff.editMember") }}
        </x-slot>

        <x-slot name="content">
            @if ($customer)
            @livewire('forms.edit-staff', ['member' => $customer], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditCustomerModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-confirmation-modal wire:model="confirmDeleteCustomerModal">
        <x-slot name="title">
            @lang('modules.staff.deleteMember')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.staff.deleteMemberMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteCustomerModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($customer)
            <x-danger-button class="ml-3" wire:click='deleteCustomer({{ $customer->id }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
         </x-slot>
    </x-confirmation-modal>

</div>
