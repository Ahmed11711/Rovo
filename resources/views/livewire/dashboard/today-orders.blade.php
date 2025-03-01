<a wire:poll.15s href="{{ route('orders.index') }}" wire:navigate
    class="hidden lg:inline-flex items-center px-3 py-1.5 text-sm font-medium text-center text-gray-600 bg-white border-skin-base border rounded-md focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-gray-800 dark:text-gray-300">
    @lang('modules.order.todayOrder')
    <span
        class="inline-flex items-center justify-center px-2 py-0.5 ms-2 text-xs font-semibold text-white bg-skin-base rounded-md">
        {{ $count }}
    </span>


    @if ($playSound)
    @script
    <script>
        new Audio("{{ asset('sound/new_order.wav')}}").play();
    </script>
    @endscript
    @endif

</a>