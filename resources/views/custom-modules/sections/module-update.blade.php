@if ($fetchSetting?->purchase_code && $fetchSetting?->supported_until)
    @if (\Carbon\Carbon::parse($fetchSetting->supported_until)->isPast())
        <div class="inline-block group relative">
            <button type="button" class="inline-flex items-center px-3 py-1 text-xs font-medium border border-gray-300 rounded hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 refreshModule"
                    data-module-name="{{ $module }}">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh
            </button>
            <div class="pointer-events-none hidden group-hover:block absolute z-50 w-64 px-4 py-2
                      left-1/2 -translate-x-1/2 bottom-full mb-2
                      text-sm text-white bg-gray-900 rounded-lg shadow-sm
                      before:content-[''] before:absolute before:left-1/2 before:-translate-x-1/2
                      before:bottom-[-6px] before:border-[6px] before:border-transparent
                      before:border-t-gray-900">
                This will fetch the latest support date from codecanyon. Click on this button only when you have renewed the support and the new support date is not reflecting
            </div>
        </div>
        <a target="_blank"
           href="{{ Froiden\Envato\Helpers\FroidenApp::renewSupportUrl($envatoId) }}"
           class="ml-1 inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-module-name="{{ $module }}">
            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Renew support now
        </a>
    @elseif(str_contains('UniversalBundle',$module))
        @if ((int)now()->diffInDays(\Carbon\Carbon::parse($fetchSetting->supported_until)) < 60)
            <button type="button" class="inline-flex items-center px-3 py-1 text-xs font-medium border border-gray-300 rounded hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 refreshModule"
                    data-module-name="{{ $module }}">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh Support
            </button>
            <a target="_blank"
               href="{{ Froiden\Envato\Helpers\FroidenApp::extendSupportUrl($envatoId) }}"
               class="ml-1 inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-module-name="{{ $module }}">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Extend Support
            </a>
        @endif
    @endif
@endif
@if($plugins->where('envato_id', $envatoId)->pluck('version')->first() > \Illuminate\Support\Facades\File::get($module->getPath() . '/version.txt'))
    <x-button  type="button" class="ml-1 inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 update-module"
            data-product-url="{{ Froiden\Envato\Helpers\FroidenApp::renewSupportUrl(config(strtolower($module) . '.envato_item_id')) }}"
            data-module-name="{{ $module }}">
        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        @lang('app.update')
    </x-button>
@endif
