<style>
    .invalid-feedback {
        color: red;
        font-size: 12px;
    }

    .alert{
        padding: 10px;
        border-radius: 5px;
    }

    .alert-success {
        color: #027302;
        font-size: 12px;
        background-color: #d1fadf;
        border: 1px solid #027302;
    }

    .alert-danger {
        color: #a50505;
        font-size: 12px;
        background-color: #f8d7da;
        border: 1px solid #a50505;
    }

    .blur-code {
        filter: blur(3px);
    }
</style>

<div class="space-y-6 mb-10">
    @if(count($allModules) > 0)
    <div class="flex mb-4">
        <x-primary-link href="{{ route('superadmin.custom-modules.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg> @lang('app.moduleSettingsInstall')
        </x-primary-link>
    </div>
    @endif

    <div id="update-area" class="my-5 p-6 bg-white rounded-lg shadow-sm hidden">
        {{__('app.loading')}}
    </div>

    <div class="hidden text-red-600 bg-red-50 p-4 rounded-lg mb-4" id="custom-module-alert"></div>


    @if(session('subdomain_module_activated') == 'activated')
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-4 ">
            <!-- Success Header -->
            <div class="flex items-center gap-3 mb-4">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-blue-800">Subdomain Module Activated Successfully!</h3>
                    <p class="text-blue-600 text-sm">Your system has been upgraded with enhanced security features.</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="space-y-4">
                <!-- New Login URL -->
                <div class="flex items-center gap-3 bg-white p-3 rounded border border-blue-100 dark:bg-gray-800 dark:text-white">
                    <div class="flex-grow">
                        <span class="text-sm text-gray-600 dark:text-white">New Superadmin URL:</span>
                        <code class="ml-2 bg-gray-50 px-2 py-1 rounded text-sm dark:bg-gray-200 dark:text-black">{{ url('/') }}/super-admin-login</code>
                    </div>
                    <button class="copy-url p-2 hover:bg-gray-100 rounded dark:text-black dark:bg-gray-800 data-url="{{ url('/') }}/super-admin-login">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                    </button>
                </div>

                <!-- Important Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded-r">
                        <span class="font-medium text-amber-800">Important Changes:</span>
                        <ul class="mt-1 ml-4 text-sm text-amber-700 list-disc">
                            <li>Public login page disabled</li>
                            <li>Company-specific subdomain logins</li>
                            <li>Update user access points</li>
                        </ul>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-400 p-3 rounded-r">
                        <span class="font-medium text-red-800">Required Actions:</span>
                        <ul class="mt-1 ml-4 text-sm text-red-700 list-disc">
                            <li>Configure DNS settings</li>
                            <li>Setup wildcard subdomains</li>
                            <li>Update saved bookmarks</li>
                        </ul>
                    </div>
                </div>

                <!-- Help Link -->
                <div class="text-sm text-gray-600">
                    Need help? <a href="https://youtu.be/4mLyhf43_wI" class="text-blue-600 hover:text-blue-800" target="_blank">Watch setup guide →</a>
                </div>
            </div>
        </div>
    @endif

    @includeIf('languagepack::module-activated-alert')
    @include('custom-modules.sections.universal-bundle')


    <div class="bg-white rounded-lg border mb-100 dark:bg-gray-800">
        <x-table class="custom-modules-table dark:bg-gray-800" headType="bg-gray-50">
            <x-slot name="thead" class="dark:bg-gray-800">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('app.name')</th>
                @if (!$universalBundle)
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('app.purchaseCode')</th>
                @endif
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('app.moduleVersion')</th>
                @if (!$universalBundle)
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('app.notify')</th>
                @endif
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">@lang('app.status')</th>
            </x-slot>

            @forelse ($allModules as $key=>$module)
                @php
                    $moduleKey = strtolower($module);
                    $fetchSetting = null;

                    // Get module config settings
                    $settingClass = config([strtolower($module) . '.setting', null]);
                    $verificationRequired = config([strtolower($module) . '.verification_required', false]);
                    $envatoId = config([strtolower($module) . '.envato_item_id', null]);

                    // Load config from Modules directory if plugin exists
                    if (in_array($moduleKey, custom_module_plugins())) {
                        $configPath = base_path("Modules/$module/Config/config.php");

                        if (file_exists($configPath)) {
                            $moduleConfig = require $configPath;
                            $settingClass = $moduleConfig['setting'] ?? $settingClass;
                            $verificationRequired = $moduleConfig['verification_required'] ?? $verificationRequired;
                            $envatoId = $moduleConfig['envato_item_id'] ?? $envatoId;

                            if ($settingClass) {
                                $fetchSetting = $settingClass::first();
                            }
                        }
                    }
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span>{{ $module }}</span>
                        @if (module_enabled('UniversalBundle') && isInstallFromUniversalBundleModule($key))
                            <i class="icon text-blue-500 fas fa-info-circle cursor-pointer" data-toggle="tooltip"
                                data-original-title="{{__('universalbundle::app.moduleInfo')}}"></i>
                        @endif
                    </td>
                    @if (!$universalBundle)
                    <td class="px-6 py-4 whitespace-nowrap text-sm flex items-center gap-2">

                        @if ($fetchSetting)
                            @if ($verificationRequired)
                                @include('custom-modules.sections.purchase-code')
                            @endif
                        @endif
                    </td>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if ($settingClass)
                            @include('custom-modules.sections.version')

                            @if ($plugins->where('envato_id', $envatoId)->first() && !(module_enabled('UniversalBundle') && isInstallFromUniversalBundleModule($key)))
                                @include('custom-modules.sections.module-update')
                            @endif
                        @endif
                    </td>

                    @if (!$universalBundle)
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        @if ($fetchSetting)
                        <div class="inline-block ml-2 group relative">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer change-module-notification"
                                    @checked($fetchSetting->notify_update)
                                    id="module-notification-{{ $key }}" data-module-name="{{ $module }}">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>

                            <!-- Tooltip -->
                            <div class="pointer-events-none hidden group-hover:block absolute z-50 w-75 px-4 py-2
                                      right-full mr-5 top-1/2 -translate-y-1/2
                                      text-sm text-white bg-gray-900 rounded-lg shadow-sm
                                      before:content-[''] before:absolute before:top-1/2 before:-translate-y-1/2
                                      before:right-[-6px] before:border-[6px] before:border-transparent
                                      before:border-l-gray-900">
                                @lang('app.moduleNotifySwitchMessage', ['name' => $module])
                            </div>
                        </div>
                        @endif
                    </td>
                    @endif

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <div class="inline-block ml-2 group relative" data-toggle="tooltip"
                             data-original-title="@lang('app.moduleSwitchMessage', ['name' => $module])">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" @if (in_array($key, custom_module_plugins())) checked @endif
                                    class="sr-only peer change-module-status"
                                    id="module-{{ $key }}" data-module-name="{{ $module }}">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>

                            <!-- Tooltip -->
                            <div class="pointer-events-none hidden group-hover:block absolute z-50 w-75 px-4 py-2
                                      right-full mr-5 top-1/2 -translate-y-1/2
                                      text-sm text-white bg-gray-900 rounded-lg shadow-sm
                                      before:content-[''] before:absolute before:top-1/2 before:-translate-y-1/2
                                      before:right-[-6px] before:border-[6px] before:border-transparent
                                      before:border-l-gray-900">
                                @lang('app.moduleSwitchMessage', ['name' => $module])
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td colspan="5" class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-gray-500">@lang('messages.noRecordFound')</span>
                            <p class="text-sm text-gray-600">@lang('messages.moduleSettingsInstall')</p>

                            <x-primary-link href="{{ route('superadmin.custom-modules.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase ">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg> @lang('app.moduleSettingsInstall')
                            </x-primary-link>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    @include('vendor.froiden-envato.update.plugins', ['allModules' => $allModules])
</div>

<!-- Subdomain Activation Modal -->
<div id="subdomainModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:w-full sm:max-w-4xl">
            <div class="bg-white">
                <div class="border-b px-4 py-3 sm:px-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Confirm Subdomain Module Activation</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500 close-modal">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-2 py-3 sm:p-4">
                    <div class="text-left">
                        <!-- Warning Banner -->
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-amber-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-amber-700">
                                        Please ensure you have properly configured wildcard subdomains on your server before proceeding.
                                    </p>
                                    <a href="https://youtu.be/4mLyhf43_wI"
                                       class="mt-3 inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 group"
                                       target="_blank">
                                        <svg class="w-5 h-5 text-red-600 group-hover:text-red-700" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Watch Configuration Guide</span>
                                        <svg class="w-3 h-3 text-gray-500 group-hover:text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Changes Section -->
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-4">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h3 class="text-base font-semibold text-gray-900">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                    Important Changes After Activation
                                </h3>
                            </div>
                            <div class="px-4 py-3">
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <i class="fas fa-link mt-1 mr-3 text-gray-400"></i>
                                        <div class="flex-grow">
                                            <span class="block text-sm text-gray-700">New Superadmin Login URL:</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <code class="flex-grow bg-gray-50 px-3 py-2 text-sm font-mono text-gray-600 rounded border border-gray-200">
                                                    {{ url('/') }}/super-admin-login
                                                </code>
                                                <button class="copy-url p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                                                        data-url="{{ url('/') }}/super-admin-login"
                                                        title="Copy URL">
                                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <p class="text-xs text-blue-600 mt-1">⭐ Click the copy icon to copy URL to clipboard</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle mt-1 mr-3 text-green-500"></i>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-900">Enhanced Security</span>
                                            <span class="text-sm text-gray-600">Public login page will be disabled for better security</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-building mt-1 mr-3 text-blue-500"></i>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-900">Restaurant-Specific Access</span>
                                            <span class="text-sm text-gray-600">Each restaurant gets a dedicated login page on their subdomain</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Warning Section -->
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r mb-4">
                            <div class="font-medium text-red-800">Warning:</div>
                            <ul class="mt-2 ml-4 text-sm text-red-700 list-disc">
                                <li>The previous admin login URL will no longer work (means public login page)</li>
                                <li>Make sure your DNS and wildcard subdomains are properly configured</li>
                                <li>Update any bookmarks or saved links to the new URL</li>
                            </ul>
                        </div>

                        <!-- Confirmation -->
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-4 text-center">Are you sure you want to proceed with activation?</p>

                            <div class="flex justify-center gap-3">
                                <button type="button"
                                        class="cancel-subdomain-activation px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Cancel
                                </button>
                                <button type="button"
                                        class="confirm-subdomain-activation px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Confirm Activation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verify Purchase Code Modal -->
<div id="verifyPurchaseModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:w-full sm:max-w-lg">
            <div class="bg-white">
                <div class="border-b px-4 py-3 sm:px-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="verifyModalHeading">Verify Purchase Code</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500 close-modal">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-4 py-5 sm:p-6" id="verifyModalBody">
                    <!-- Content will be loaded dynamically -->
                </div>

                <div class="border-t px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="close-modal mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const SUBDOMAIN_MODAL = '#subdomainModal';
    const VERIFY_MODAL = '#verifyPurchaseModal';
</script>

<script src="{{ asset('vendor/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/froiden-helper/helper.js') }}"></script>

@include('vendor.froiden-envato.update.update_script')

<script>
    $('body').on('click', '.show-hide-purchase-code', function () {
        $('> .eye-icon', this).toggleClass('hidden');
        $('> .eye-slash-icon', this).toggleClass('hidden');
        $(this).siblings('span').toggleClass('blur-code ');
    });

    $('body').on('change', '.change-module-status', function () {
        let moduleStatus;
        const module = $(this).data('module-name');
        const checkbox = $(this);

        if ($(this).is(':checked')) {
            moduleStatus = 'active';

            // Show confirmation for subdomain module activation
            if (module === 'Subdomain') {
                // Uncheck the checkbox initially
                checkbox.prop('checked', false);
                $(SUBDOMAIN_MODAL).removeClass('hidden');
                return;
            }
        } else {
            moduleStatus = 'inactive';
        }

        updateModuleStatus(module, moduleStatus);
    });

    $('body').on('click', '.cancel-subdomain-activation', function() {
        $(SUBDOMAIN_MODAL).addClass('hidden');
    });

    $('body').on('click', '.confirm-subdomain-activation', function() {
        const module = 'Subdomain';
        $('#module-' + module).prop('checked', true);
        $(SUBDOMAIN_MODAL).addClass('hidden');
        updateModuleStatus(module, 'active');
    });

    function updateModuleStatus(module, moduleStatus) {
        let url = "{{ route('superadmin.custom-modules.update', ':module') }}";
        url = url.replace(':module', module);

        $('#custom-module-alert').addClass('d-none');

        $.easyAjax({
            url: url,
            type: "POST",
            disableButton: true,
            buttonSelector: ".change-module-status",
            container: '.custom-modules-table',
            blockUI: true,
            data: {
                'id': module,
                'status': moduleStatus,
                '_method': 'PUT',
                '_token': '{{ csrf_token() }}'
            },
            error: function (response) {
                if (response.responseJSON) {
                    $('#custom-module-alert').html(response.responseJSON.message).removeClass('d-none');
                    $('#module-' + module).prop('checked', false);
                }
            }
        });
    }

    $('body').on('click', '.verify-module', function () {
        const module = $(this).data('module');
        let url = "{{ route('superadmin.custom-modules.show', ':module') }}";
        url = url.replace(':module', module);
        $.easyAjax({
            url: url,
            container: '#verifyModalBody',
            blockUI: true,
            success: function (response) {
                if (response.status === 'success') {
                    $('#verifyModalBody').html(response.html);
                }
            },
            error: function (response) {
                if (response.responseJSON) {
                    $('#custom-module-alert').html(response.responseJSON.message).removeClass('d-none');
                    $('#module-' + module).prop('checked', false);
                }
            }
        });
        $(VERIFY_MODAL).removeClass('hidden');
    });

    $('body').on('click', '.close-modal', function () {
        $(SUBDOMAIN_MODAL).addClass('hidden');
        $(VERIFY_MODAL).addClass('hidden');
    });

    $('body').on('click', '.copy-url', function() {
        const url = $(this).data('url');
        const button = $(this);
        const originalHTML = button.html();

        // Create temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);

        // Select and copy
        tempInput.select();
        try {
            document.execCommand('copy');
            // Show success state
            button.html(`
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            `);

            // Revert back after 2 seconds
            setTimeout(() => {
                button.html(originalHTML);
            }, 2000);
        } catch (err) {
            console.error('Failed to copy URL:', err);
        }

        // Remove temporary input
        document.body.removeChild(tempInput);
    });
</script>

@includeIf('vendor.froiden-envato.update.update_module')

