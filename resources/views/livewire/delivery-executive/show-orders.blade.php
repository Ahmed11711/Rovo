<div>
    <div class=" bg-white block sm:flex items-center justify-between dark:bg-gray-800 dark:border-gray-700 mb-4">
        <div class="inline-flex gap-4 items-center">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ $customer->name }}</h1>

            <span class='text-xs h-fit font-medium px-2 py-1 rounded uppercase tracking-wide whitespace-nowrap bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400 border border-gray-400'>
                    {{ $customer->orders->count() }} @lang('menu.orders')
            </span>
        </div>
        
    </div>

    <div class="flex flex-col">

        <!-- Card Section -->
        <div class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-3 sm:gap-4">
                @foreach ($customer->orders as $item)
                    <x-order.order-card :order='$item' wire:key='order-{{ $item->id . microtime() }}' />
                @endforeach
            </div>
        </div>
        <!-- End Card Section -->


    </div>
</div>
