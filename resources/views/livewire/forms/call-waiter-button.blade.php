<div class="flex flex-col items-center space-y-4">
    <!-- Call Waiter Button -->
    <x-button 
        wire:click="callWaiter" class="inline-flex items-center gap-1 "
    >
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
      </svg>
        <span>@lang('app.callWaiter')</span>
    </x-button>

    @if ($showTableSelection)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-md p-6 text-center space-y-4">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">@lang('modules.table.selectTable')</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach ($tables as $table)
                    <button 
                        wire:click="selectTable({{ $table->id }})"
                        class="flex items-center justify-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-skin-base hover:text-white hover:border-skin-base transition-colors duration-200 dark:bg-gray-800 dark:text-gray-300"
                    >
                        <span class="text-lg font-semibold">{{ $table->table_code }}</span>
                    </button>
                @endforeach
            </div>
            <button 
                wire:click="cancelCall"
                class="mt-4 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded"
            >
                @lang('app.cancel')
            </button>
            </div>
        </div>
    </div>
    @endif
    <!-- Confirmation Popup -->
    @if ($showConfirmation)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-md p-6 text-center space-y-4">
            <p class="text-gray-700 dark:text-gray-300 text-sm font-semibold">@lang('app.callWaiterConfirmation') (@lang('modules.table.table') {{ $table->table_code ?? ''  }})</p>
            <div class="flex space-x-4 justify-center">
                <button 
                    wire:click="confirmCall" 
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded"
                >
                    @lang('app.yes')
                </button>
                <button 
                    wire:click="cancelCall" 
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded"
                >
                    @lang('app.no')
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Notification Message -->
    @if ($notificationSent)
    <div 
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 3000)" 
    x-show="show" 
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
>
    <div 
        class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-6 py-4 rounded-lg shadow-lg text-center"
    >
            @lang('app.callWaiterNotification')
        </div>
        </div>
    @endif
</div>