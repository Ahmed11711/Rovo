<div>
    <div
    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="w-full">
            <h3 class="text-base font-normal text-gray-500 dark:text-gray-400 mb-4">@lang('modules.dashboard.topTables') (@lang('app.today'))
            </h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($orders as $item)
                    <li class="py-1 sm:py-2">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="flex-1 min-w-0">
                                <div class="w-full max-w-smspace-y-2">
                                    <div >
                                        <div class="flex items-center gap-3">

                                            <span class="text-gray-400 text-sm">#{{ $loop->index+1 }}</span>

                                            <div @class(['p-2 rounded-md tracking-wide bg-skin-base/[0.2] text-skin-base'])>
                                                <h3 wire:loading.class.delay='opacity-50'
                                                    @class(['font-semibold'])>
                                                    {{ $item?->table?->table_code }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inline-flex items-center text-base font-medium text-gray-900 dark:text-white">
                                {{ currency_format($item->total_price) }}
                            </div>
                        </div>
                    </li>
                @empty
                <li class="py-2">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            @lang('messages.noPaymentFound')
                        </p>
                    </div>
                    </div>
                </li>
                @endforelse


            </ul>

        </div>
    </div>
</div>
