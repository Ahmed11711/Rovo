<style>
    .note {
        margin-bottom: 15px;
        padding: 15px;
        background-color: #e7f3fe;
        border-left: 6px solid #2196F3;
    }

    ul,
    li {
        list-style: inherit;
        line-height: 20px;
    }

    .note ul {
        margin-bottom: 20px;
        margin-top: 2px;
        margin-left: 10px;
    }


</style>
<div class="flex">
    <div class="w-full">
        @php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())

        @include('vendor.froiden-envato.update.support-extend-renewal')

        @if (isset($updateVersionInfo['lastVersion']))

            <x-alert type="danger">
                <ol class="mb-0">
                    <li class="tracking-wide">@lang('messages.updateAlert')</li>
                    <li class="tracking-wide">@lang('messages.updateBackupNotice')</li>
                </ol>
            </x-alert>

            <div id="update-area" class="hidden p-4">
                {{__('app.loading')}}
            </div>

            <div class="note bg-blue-100 p-2.5 rounded dark:bg-blue-900 dark:text-blue-300 text-blue-800">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <div class="flex-1">
                        <h6 class="text-xl flex items-center gap-2">
                            <svg class="fa-gift f-20 w-6  pb-1" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="gift" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h160V320H32v128zm256 32h160c17.7 0 32-14.3 32-32V320H288v160zm192-320h-42.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H32c-17.7 0-32 14.3-32 32v80c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16v-80c0-17.7-14.3-32-32-32zm-326.1 0c-22.1 0-40-17.9-40-40s17.9-40 40-40c19.9 0 34.6 3.3 86.1 80h-86.1zm206.1 0h-86.1c51.4-76.5 65.7-80 86.1-80 22.1 0 40 17.9 40 40s-17.9 40-40 40z"></path></svg>
                            @lang('modules.update.newUpdate')
                            <span class="text-xs font-medium px-2 py-1 rounded uppercase tracking-wide whitespace-nowrap bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-400 border border-green-400">{{ $updateVersionInfo['lastVersion'] }}</span>
                        </h6>
                        <div class="mt-3">
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Note:</span>
                            You will be logged out after the update. Please log in again to continue using the application.
                        </div>
                        <div class=" mt-3">@lang('modules.update.updateAlternate')</div>
                    </div>
                    <div class="flex justify-end mt-3">
                        <x-button id="update-app" link="javascript:;" icon="download">
                            @lang('modules.update.updateNow')
                        </x-button>
                    </div>
                </div>

                <div class="mt-5">
                    <h6 class="text-lg font-semibold border-b mb-2 "><i class="fa fa-history text-lg"></i> Update Summary</h6>
                    <div class="text-sm tracking-wide ">{!! $updateVersionInfo['updateInfo'] !!}</div>
                </div>
            </div>


        @else
            <x-alert type="info">
                You have the latest version of this app.
            </x-alert>
        @endif
    </div>
</div>


<script src="{{ asset('vendor/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/froiden-helper/helper.js') }}"></script>
