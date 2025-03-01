<div>

    @assets
    <script src="{{ asset('vendor/pikaday.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/pikaday.css') }}">
    @endassets

    <div class="p-4 bg-white block  dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.reservations')</h1>
        </div>

        <div class="flex flex-col my-4">
            <!-- Card Section -->
            <div class="space-y-4">
                <x-upgrade-box :title="__('modules.reservation.upgradeHeading')"
                               :text="__('modules.reservation.upgradeInfo')"></x-upgrade-box>
            </div>
            <!-- End Card Section -->
        </div>
    </div>
</div>
