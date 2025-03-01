<div>
    <div
        class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">

        <h3 class="mb-4 text-xl font-semibold dark:text-white inline-flex gap-4 items-center">@lang('modules.settings.restaurantSettings')</h3>

        <form wire:submit="submitForm">
            <div class="grid gap-6">

                <div class="flex items-center justify-between py-4">
                    <div class="flex flex-col flex-grow">
                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                            @lang('modules.settings.restaurantRequiresApproval')
                        </div>
                        <div class="text-base font-normal text-gray-500 dark:text-gray-400">
                            @lang('modules.settings.restaurantRequiresApprovalInfo')
                        </div>
                    </div>

                    <label for="requiresApproval" class="relative flex items-center cursor-pointer">
                        <input type="checkbox" id="requiresApproval" wire:model='requiresApproval' class="sr-only">
                        <span class="h-6 bg-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
                    </label>
                </div>

                <div>
                    <x-button>@lang('app.save')</x-button>
                </div>
            </div>
        </form>
    </div>

</div>
