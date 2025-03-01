<div>
    <div>

        <div class="p-4 bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.payments')</h1>
                </div>
                <div class="items-center justify-between block sm:flex ">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Search</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <x-input id="menu_name" class="block mt-1 w-full" type="text" placeholder="{{ __('placeholders.searchPayments') }}" wire:model.live.debounce.500ms="search"  />
                            </div>
                        </form>
                    </div>

                    <a href="{{ route('payments.export') }}" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                        @lang('app.export')
                    </a>
        
                </div>
            </div>

        </div>
        
        <livewire:payments.payments-table :search='$search' key='payment-table-{{ microtime() }}' />
    
    
    </div>
    </div>
