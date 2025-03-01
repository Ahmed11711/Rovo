@props(['modal' => false, 'showModal' => false])

@if($modal)
@if ($globalSetting->last_cron_run && Carbon\Carbon::parse($globalSetting->last_cron_run)->diffInHours() > 48)
    <div x-data="{ open: false }">
            <div class="col-md-12 cursor-pointer" >
                <x-alert type="danger" icon="exclamation-circle">
                    <div class="flex justify-between items-center">
                        <div class="flex-grow">@lang('messages.cronIsNotRunning')</div>
                        <div class="font-bold ml-4">
                        <x-secondary-button @click="open = true">    @lang('messages.cronJobSetting')
                        </x-secondary-button>
                        </div>
                    </div>
                </x-alert>
            </div>

        <div x-show="open"
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            x-ref="dialog"
            @click.away="open = false"
            aria-modal="true">

            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Background overlay -->
                <div x-show="open"
                    x-cloak
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
                </div>

                <!-- Modal panel -->
                <div x-show="open"
                    x-cloak
                    class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all w-full max-w-6xl mx-auto">

                    <!-- Close button at top right -->
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button type="button"
                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none"
                            @click="open = false">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                @lang('messages.cronJobSetting')
                            </h3>
                            <div class="mt-4">
                                @include('superadmin-settings.cron-message')
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-4 flex justify-end">
                        <button type="button"
                            class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            @click="open = false">
                            @lang('app.close')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@elseif($globalSetting->hide_cron_job !== 1)
    @include('superadmin-settings.cron-message')
@endif
