<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($modulesData as $setting)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ __('modules.module.'.$setting->module_name) }}
                        </h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{ ucfirst($setting->status) }}
                        </p>
                    </div>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                            @if ($setting->status == 'active') checked @endif
                            @if($setting->module_name == 'settings') @endif
                            class="sr-only peer change-module-setting"
                            id="module-{{ $setting->id }}"
                            data-setting-id="{{ $setting->id }}"
                            data-module-name="{{ $setting->module_name }}"
                        >
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
