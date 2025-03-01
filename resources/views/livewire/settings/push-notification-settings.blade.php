<div>
    <div
        class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">

        <h3 class="mb-4 text-xl font-semibold dark:text-white inline-flex gap-4 items-center">@lang('modules.settings.pushNotificationSettings')
            <img src='{{ asset('img/Beams logo primary.png') }}' class='h-7 dark:mix-blend-plus-lighter' />

            <a href='https://pusher.com/tutorials/getting-started-pusher-beams/' target='_blank' class='text-sm font-medium inline-flex gap-1'>@lang('app.generateCredentials')
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5"/>
                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z"/>
                </svg>
            </a>
        </h3>

        <form wire:submit="submitForm">
            <div class="grid gap-6">

                <div>
                    <x-label for="beamerStatus">
                        <div class="flex items-center cursor-pointer">
                            <x-checkbox name="beamerStatus" id="beamerStatus" wire:model.live='beamerStatus'  />

                            <div class="ms-2">
                                @lang('modules.settings.enablePushNotification')
                            </div>
                        </div>
                    </x-label>
                </div>

                @if ($beamerStatus)
                    <div>
                        <x-label for="instanceID" value="Pusher Instance ID" />
                        <x-input id="instanceID" class="block mt-1 w-full" type="text" wire:model='instanceID' />
                        <x-input-error for="instanceID" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="beamSecret" value="Pusher Beam Secret" />
                        <x-input-password id="beamSecret" class="block mt-1 w-full" wire:model='beamSecret' />
                        <x-input-error for="beamSecret" class="mt-2" />
                    </div>
                @endif

                <div>
                    <x-button>@lang('app.save')</x-button>
                </div>
            </div>
        </form>
    </div>

</div>
