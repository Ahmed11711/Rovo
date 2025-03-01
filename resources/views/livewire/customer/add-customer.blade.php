<x-dialog-modal wire:model.live="showAddCustomerModal">
    <x-slot name="title">
        <h2 class="text-lg">@lang('modules.customer.addCustomer')</h2>
    </x-slot>

    <x-slot name="content">
        <form wire:submit="submitForm">
            @csrf
            <div class="space-y-4">
                <div>
                    <x-label for="customer_name" value="{{ __('modules.customer.name') }}" />
                    <div class="mb-2" wire:key="search-input">
                        <x-input id="customer_name" type="text" name="menu_name" x-on:click="open = open"
                             class="block w-full placeholder:italic" wire:model.live.debounce.300ms="customerName" autofocus
                             autocomplete="off" placeholder="{{ __('modules.customer.enterCustomerName') }}" />
                    </div>

                    <!-- Dropdown for search results -->
                    <div class="relative" @click.away="$wire.call('resetSearch')">
                        @if($availableResults && count($availableResults) > 0)
                        <div class="absolute z-50 mt-1 border-gray-300 bg-white w-full rounded-md shadow-xl max-h-56 overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-400 hover:scrollbar-thumb-indigo-600 scrollbar-track-gray-200">
                            <!-- Loop through available search results -->
                            @foreach($availableResults as $result)
                            <div wire:key="customer-{{ $result->id }}" wire:click="selectCustomer({{ $result->id }})" class="flex items-center p-3 hover:bg-indigo-50 dark:bg-gray-700 dark:hover:bg-gray-600 cursor-pointer border-b dark:border-gray-700">
                                <div class="w-8 h-8 flex-shrink-0 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-indigo-600 dark:text-indigo-400 text-sm">{{ substr($result->name, 0, 1) }}</span>
                                </div>
                                <div class="truncate">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $result->name }}</div>
                                    @if($result->email || $result->phone)
                                    <div class="text-xs mt-1 flex items-center space-x-2 text-gray-500 dark:text-gray-300">
                                        @if($result->email)
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 8 7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2"/></svg>
                                            {{ $result->email }}
                                        </div>
                                        @endif

                                        @if($result->email && $result->phone)
                                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                        @endif

                                        @if($result->phone)
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.04 11.04 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6z"/></svg>
                                            {{ $result->phone }}
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <x-input-error for="customerName" class="mt-2" />
                </div>
                <div>
                    <x-label for="customerPhone" value="{{ __('modules.customer.phone') }}" />
                    <x-input id="customerPhone" class="block mt-1 w-full" type="tel" name="customerPhone"  wire:model='customerPhone' />
                    <x-input-error for="customerPhone" class="mt-2" />
                </div>
                <div>
                    <x-label for="customerEmail" value="{{ __('modules.customer.email') }}" />
                    <x-input id="customerEmail" class="block mt-1 w-full" type="email" name="customerEmail"  wire:model='customerEmail' />
                    <x-input-error for="customerEmail" class="mt-2" />
                </div>
                <div>
                    <x-label for="customerAddress" value="{{ __('modules.customer.address') }}" />
                    <x-textarea id="customerAddress" class="block mt-1 w-full" name="customerAddress" rows="3" wire:model='customerAddress' />
                    <x-input-error for="customerAddress" class="mt-2" />
                </div>
            </div>

            <div class="flex w-full pb-4 space-x-4 mt-6">
                <x-button>@lang('app.save')</x-button>
                <x-button-cancel  wire:click="$set('showAddCustomerModal', false)">@lang('app.cancel')</x-button-cancel>
            </div>
        </form>
    </x-slot>
</x-dialog-modal>
