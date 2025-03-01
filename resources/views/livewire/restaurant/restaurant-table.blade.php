<div>

    <div class="flex flex-col">
        <div>
            <div class="md:inline-block min-w-full align-middle">
                <div class="shadow overflow-x-auto h-screen md:h-auto md:overflow-x-visible">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.id')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.restaurantName')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.restaurantEmailAddress')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.settings.package')
                                </th>
                                <th scope="col" class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('app.status')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='member-list-{{ microtime() }}'>

                            @forelse ($restaurants as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='member-{{ $item->id . rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->id ?? '--' }}
                                </td>

                                <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white inline-flex gap-2 items-center">
                                    <img src="{{  $item->logoUrl }}" class="h-8" alt="App Logo" />
                                    <div class="flex flex-col items-start gap-y-1">
                                        <a href="{{ route('superadmin.restaurants.show', $item->hash) }}" wire:navigate class="underline underline-offset-1 font-medium">{{ $item->name }}</a>

                                        @if(module_enabled('Subdomain'))
                                            <div class="flex flex-col items-center gap-y-1">
                                                <a href="https://{{ $item->sub_domain }}" target="_blank"  class="underline  flex items-center gap-x-1 underline-offset-1 font-normal">{{ $item->sub_domain }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5"/>
                                                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="inline-flex items-center gap-x-1">
                                            <span class="text-xs text-gray-600 border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 bg-gray-200 px-2 py-1 rounded-md">{{ $item->branches_count }} @lang('modules.settings.branches')</span>
                                            @if ($item->approval_status == 'Pending')
                                            <svg class="h-5 w-5 text-yellow-400" width="24px" height="24px" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"/> <title>Approval Pending</title> <g stroke-linecap="round" stroke-linejoin="round"/><g fill="currentColor"><path opacity=".5" d="M3 10.417c0-3.198 0-4.797.378-5.335.377-.537 1.88-1.052 4.887-2.081l.573-.196C10.405 2.268 11.188 2 12 2s1.595.268 3.162.805l.573.196c3.007 1.029 4.51 1.544 4.887 2.081C21 5.62 21 7.22 21 10.417v1.574c0 5.638-4.239 8.375-6.899 9.536C13.38 21.842 13.02 22 12 22s-1.38-.158-2.101-.473C7.239 20.365 3 17.63 3 11.991z"/><path d="M10.03 8.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.97 1.97a.75.75 0 1 0 1.06 1.06L12 13.06l1.97 1.97a.75.75 0 0 0 1.06-1.06L13.06 12l1.97-1.97a.75.75 0 1 0-1.06-1.06L12 10.94z"/></g></svg>
                                            @elseif ($item->approval_status == 'Rejected')
                                            <svg class="h-5 w-5 text-red-500" width="24px" height="24px" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"/> <title>Rejection Reason: {{ $item->rejection_reason }}</title> <g stroke-linecap="round" stroke-linejoin="round"/><g fill="currentColor"><path opacity=".5" d="M3 10.417c0-3.198 0-4.797.378-5.335.377-.537 1.88-1.052 4.887-2.081l.573-.196C10.405 2.268 11.188 2 12 2s1.595.268 3.162.805l.573.196c3.007 1.029 4.51 1.544 4.887 2.081C21 5.62 21 7.22 21 10.417v1.574c0 5.638-4.239 8.375-6.899 9.536C13.38 21.842 13.02 22 12 22s-1.38-.158-2.101-.473C7.239 20.365 3 17.63 3 11.991z"/><path d="M10.03 8.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.97 1.97a.75.75 0 1 0 1.06 1.06L12 13.06l1.97 1.97a.75.75 0 0 0 1.06-1.06L13.06 12l1.97-1.97a.75.75 0 1 0-1.06-1.06L12 10.94z"/></g></svg>
                                            @endif
                                        </div>

                                    </div>

                                </td>

                                <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->email ?? '--' }}
                                </td>


                                <td class="py-2.5 px-4 text-sm text-gray-900 whitespace-nowrap dark:text-white flex flex-col items-start gap-y-1.5">

                                    <span>
                                        {{ $item?->package->package_name }} ({{ $item?->package_type }})
                                    </span>

                                    <span wire:click="showChangePackage({{ $item->id }})" wire:key='package-update-{{ $item->id . microtime() }}' class="bg-gray-100 hover:bg-gray-200 text-gray-700 select-none text-xs cursor-pointer font-medium inline-flex items-center px-1.5 py-0.5 rounded  dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-400 border border-gray-500 ">
                                        <svg class="w-4 h-4 text-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                        </svg>
                                        @lang('app.change')
                                    </span>
                                </td>

                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($item->is_active == true)
                                    <span class="bg-green-100 uppercase text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">@lang('app.active')</span>
                                @else
                                    <span class="bg-red-100 uppercase text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">@lang('app.inactive')</span>
                                @endif
                                </td>

                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right">
                                    <x-dropdown align="right">
                                        <x-slot name="trigger">
                                            <button type="button"
                                                 class="inline-flex items-center px-3 py-2 border uppercase dark:border-gray-400 text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                                <span>@lang('app.action')</span>
                                                <svg class="w-2.5 h-2.5 ms-1" height="24" width="24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 10 6">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">

                                            @if ($item->approval_status == 'Pending')
                                                <x-dropdown-link wire:click="confirmApprovalStatus({{ $item->id }}, 'Approved')" class="text-green-500 dark:text-green-400">
                                                    @lang('app.approve')
                                                </x-dropdown-link>

                                                <x-dropdown-link wire:click="confirmApprovalStatus({{ $item->id }}, 'Rejected')" class="text-yellow-500 dark:text-yellow-400">
                                                    @lang('app.reject')
                                                </x-dropdown-link>
                                            @endif

                                            <x-dropdown-link wire:click='showEditCustomer({{ $item->id }})' wire:key='member-edit-{{ $item->id . microtime() }}'>
                                                @lang('app.update')
                                            </x-dropdown-link>
                                            <x-dropdown-link wire:click="showDeleteCustomer({{ $item->id }})"  wire:key='member-del-{{ $item->id . microtime() }}' class="text-red-600 dark:text-red-400">
                                                @lang('app.delete')
                                            </x-dropdown-link>

                                        </x-slot>
                                    </x-dropdown>
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 space-x-6" colspan="8">
                                    @lang('messages.noRestaurantFound')
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
            {{ $restaurants->links() }}
        </div>
    </div>

    <x-right-modal wire:model.live="showEditCustomerModal">
        <x-slot name="title">
            {{ __("modules.restaurant.editRestaurant") }}
        </x-slot>

        <x-slot name="content">
            @if ($restaurant)
            @livewire('forms.edit-restaurant', ['restaurant' => $restaurant], key(str()->random(50)))
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
            @lang('modules.restaurant.deleteRestaurant')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.restaurant.deleteRestaurantMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteCustomerModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            @if ($restaurant)
            <x-danger-button class="ml-3" wire:click='deleteCustomer({{ $restaurant->id }})' wire:loading.attr="disabled">
                {{ __('app.delete') }}
            </x-danger-button>
            @endif
         </x-slot>
    </x-confirmation-modal>

    <x-right-modal wire:model.live="showChangePackageModal">
        <x-slot name="title">
            {{ __("modules.restaurant.updatePackage") }}
        </x-slot>

        <x-slot name="content">
            @if ($restaurant)
            @livewire('forms.update-package', ['restaurant' => $restaurant], key(str()->random(50)))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showChangePackageModal', false)" wire:loading.attr="disabled">
                {{ __('app.close') }}
            </x-secondary-button>
        </x-slot>
    </x-right-modal>

    <x-dialog-modal wire:model.live="showRejectionReasonModal">
        <x-slot name="title">
            @lang('modules.restaurant.rejectionReason')
        </x-slot>

        <x-slot name="content">
            <x-textarea id="rejectionReason" class="block mt-1 w-full" data-gramm="false" name="rejectionReason" placeholder="{{ __('modules.restaurant.rejectionReasonPlaceholder') }}" rows="3" wire:model='rejectionReason' />
            <x-input-error for="rejectionReason" class="mt-2" />
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showRejectionReasonModal', false)" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="saveRejectionReason" wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

</div>
