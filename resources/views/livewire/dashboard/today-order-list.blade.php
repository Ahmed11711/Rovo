<div>
    <h1 class="text-xl font-semibold text-gray-900 sm:text-xl dark:text-white my-2">@lang('modules.order.todayOrder')</h1>

    <div class="grid grid-cols-1 gap-3 sm:gap-4">
        @forelse ($orders as $item)
            <x-order.order-card :order='$item' wire:key='order-{{ $item->id . microtime() }}' />
        @empty
            <div class="group flex justify-center gap-3 items-center border h-36 font-medium bg-white shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600 p-3 dark:text-gray-400">
               @lang('messages.waitingTodayOrder')
            </div>
        @endforelse
    </div>
</div>
