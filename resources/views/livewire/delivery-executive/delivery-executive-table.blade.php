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
                                    @lang('modules.customer.phone')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.order.totalOrder')
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
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='customer-list-{{ microtime() }}'>

                            @forelse ($members as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='customer-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->name }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->phone ?? '--' }}
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <span
                                    @if(user_can('Show Order'))
                                     wire:click='showCustomerOrders({{ $item->id }})'
                                    @endif

                                     @class(['text-xs font-medium px-2 py-1 rounded uppercase tracking-wide whitespace-nowrap bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400 border border-gray-400 cursor-pointer'])>
                                        {{ $item->orders_count }} @lang('menu.orders')
                                    </span>
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    <span @class(['text-xs font-medium px-2 py-1 rounded uppercase tracking-wide whitespace-nowrap ',
                                    'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-400 border border-blue-400' => ($item->status == 'on_delivery'),
                                    'bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-400 border border-green-400' => ($item->status == 'available'),
                                    'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-400 border border-red-400' => ($item->status == 'inactive'),
                                    ])>
                                        @lang('modules.staff.' . $item->status)
                                    </span>
                                </td>

                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right rtl:space-x-reverse">
                                    @if(user_can('Update Delivery Executive'))
                                    <x-secondary-button-table wire:click='showEditCustomer({{ $item->id }})' wire:key='customer-edit-{{ $item->id . microtime() }}'
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

                                    @if(user_can('Delete Delivery Executive'))
                                    <x-danger-button-table wire:click="showDeleteCustomer({{ $item->id }})"  wire:key='customer-del-{{ $item->id . microtime() }}'>
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
            {{ __("modules.staff.editExecutive") }}
        </x-slot>

        <x-slot name="content">
            @if ($customer)
            @livewire('forms.editExecutive', ['member' => $customer], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditCustomerModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-right-modal wire:model.live="showCustomerOrderModal" maxWidth="3xl">
        <x-slot name="title">
            {{ __("menu.orders") }}
        </x-slot>

        <x-slot name="content">
            @if ($customer)
            @livewire('deliveryExecutive.showOrders', ['customer' => $customer], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showCustomerOrderModal', false)" wire:loading.attr="disabled">
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
