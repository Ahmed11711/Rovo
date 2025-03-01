<div class="grid grid-cols-1 px-4">

    <form wire:submit="submitForm" class="space-y-6">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 xl:mb-0">
            <div class="flow-root">
                <h3 class="text-xl font-semibold dark:text-white">@lang('modules.settings.notificationSettings')</h3>

                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($notificationSettings as $key => $item)
                    <!-- Item 1 -->
                    <div class="flex items-center justify-between py-4">
                        <div class="flex flex-col flex-grow">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">@lang('modules.notifications.'
                                . $item->type)</div>
                            <div class="text-base font-normal text-gray-500 dark:text-gray-400">
                                @lang('modules.notifications.' . $item->type.'_info')</div>
                        </div>

                        <label for="checkbox_{{ $item->type }}" class="relative flex items-center cursor-pointer"
                            wire:key='send_email_{{ microtime() }}'>
                            <input type="checkbox" id="checkbox_{{ $item->type }}" @checked($sendEmail[$key])
                                wire:model.live='sendEmail.{{ $key }}' class="sr-only">
                            <span
                                class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
                        </label>
                    </div>
                    @endforeach

                </div>

                <div class="mt-6">
                    <x-button>@lang('app.save')</x-button>
                </div>

            </div>
        </div>
    </form>
</div>