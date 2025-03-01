
@php($envatoUpdateCompanySetting = \Froiden\Envato\Functions\EnvatoUpdate::companySetting())

<div class="flex flex-col  space-y-6">
    {{-- System Details Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm ">
        <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    @lang('modules.update.systemDetails')
                </h3>
            </div>
        </div>

        <div class="px-6 py-4 space-y-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">App Version</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-medium dark:text-white">{{ $updateVersionInfo['appVersion'] }}</span>
                    @if(!isset($updateVersionInfo['lastVersion']))
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
            </div>

            @if(!app()->environment(['codecanyon','demo']))
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">App Environment</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium dark:text-white">{{ app()->environment() }}</span>
                        @if(!isset($updateVersionInfo['lastVersion']))
                            <svg class="w-5 h-5 text-red-500 animate-pulse duration-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" data-tooltip-target="env-warning">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div id="env-warning" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-1 mr-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700 w-[300px] whitespace-normal overflow-hidden">
                                It seems you have changed the <span class="text-yellow-300 font-bold">APP_ENV=codecanyon</span> to something else in .env file.
                                Please do not change it, otherwise, the application will not work properly.
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">Laravel Version</span>
                </div>
                <span class="font-medium dark:text-white">{{ $updateVersionInfo['laravelVersion'] }}</span>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-gray-600 dark:text-gray-400">PHP Version</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-medium dark:text-white">{{ phpversion() }}</span>
                    @if (version_compare(PHP_VERSION, '8.2.0') >= 0)
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" data-tooltip-target="php-warning">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    @endif
                </div>
            </div>

            @if(!is_null($mysql_version))
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">{{ $databaseType }}</span>
                    </div>
                    <span class="font-medium dark:text-white">{{ $mysql_version }}</span>
                </div>
            @endif

            @if(!app()->environment(['demo']))
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">Server OS</span>
                    </div>
                    <span class="font-medium dark:text-white">{{ php_uname('s') . ' ' . php_uname('r') }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">Memory Limit</span>
                    </div>
                    <span class="font-medium dark:text-white">{{ ini_get('memory_limit') }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">Max Execution Time</span>
                    </div>
                    <span class="font-medium dark:text-white">{{ ini_get('max_execution_time') }}s</span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">Upload Max Filesize</span>
                    </div>
                    <span class="font-medium dark:text-white">{{ ini_get('upload_max_filesize') }}</span>
                </div>
            @endif

        </div>
    </div>

    @if(!is_null($envatoUpdateCompanySetting->purchase_code))
        {{-- License Details Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">License Details</h3>
                </div>
            </div>

            <div class="px-6 py-4 space-y-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        <span class="text-gray-600 dark:text-gray-400">Envato Purchase Code</span>
                    </div>
                    <div class="flex items-center gap-2">

                        <span class="purchase-code blur-sm transition duration-300 font-medium dark:text-white bg-gray-100 px-1 py-1 rounded cursor-pointer group relative"
                        onclick="copyPurchaseCode(this)" data-code="{{$envatoUpdateCompanySetting->purchase_code}}">
                            {{$envatoUpdateCompanySetting->purchase_code}}
                        </span>
                        <button class="show-hide-purchase-code" data-tooltip-target="purchase-tooltip-toggle">
                            <svg class="icon hidden w-5 h-5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            <svg class="icon w-5 h-5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                            </svg>
                        </button>

                        <a href="{{route('verify-purchase')}}" class="ml-4 text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 font-medium">
                            Change Purchase Code
                        </a>
                    </div>
                </div>

                @if(!is_null($envatoUpdateCompanySetting?->purchased_on))
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-600 dark:text-gray-400">Purchased On</span>
                        </div>
                        <span class="font-medium dark:text-white">
                            {{\Carbon\Carbon::parse($envatoUpdateCompanySetting->purchased_on)->translatedFormat('D d M, Y')}}
                            <span class="text-sm text-gray-500">
                                ({{\Carbon\Carbon::parse($envatoUpdateCompanySetting->purchased_on)->diffForHumans()}})
                            </span>
                        </span>
                    </div>
                @endif

                @if(!is_null($envatoUpdateCompanySetting?->supported_until))
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-600 dark:text-gray-400">Support Expires</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-medium dark:text-white">
                                {{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->translatedFormat('D d M, Y')}}
                                <span class="text-sm text-gray-500">
                                    ({{\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->diffForHumans()}})
                                </span>
                            </span>
                            @if(\Carbon\Carbon::parse($envatoUpdateCompanySetting->supported_until)->lessThan(now()))
                                <span class="px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                    Expired
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                @if(!is_null($envatoUpdateCompanySetting->license_type))
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <span class="text-gray-600 dark:text-gray-400">License Type</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-medium dark:text-white">
                                {{$envatoUpdateCompanySetting->license_type}}
                            </span>
                            @if(str_contains($envatoUpdateCompanySetting->license_type, 'Regular'))
                                <a href="{{'https://codecanyon.net/checkout/from_item/' . config('froiden_envato.envato_item_id') . '?license=extended'}}"
                                   class="text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 font-medium"
                                   target="_blank">
                                    Upgrade now
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
document.body.addEventListener('click', function (event) {
    if (event.target.closest('.show-hide-purchase-code')) {
        const button = event.target.closest('.show-hide-purchase-code');
        const icons = button.querySelectorAll('.icon');
        const siblingSpan = button.previousElementSibling;

        siblingSpan.classList.toggle('blur-sm');
        icons.forEach(icon => icon.classList.toggle('hidden'));
    }
});

</script>
