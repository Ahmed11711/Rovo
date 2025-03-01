@if ($fetchSetting->purchase_code)

    <div class="flex items-center gap-2">
        <code class="blur-sm purchase-code text-sm bg-gray-100 px-1 py-1 rounded">{{ $fetchSetting->purchase_code }}</code>

        <button type="button" class="text-gray-500 hover:text-gray-700 rounded-lg show-hide-purchase-code group relative">
            <svg class="icon hidden w-4 h-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
            </svg>
            <svg class="icon w-4 h-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
            </svg>
            <!-- Tooltip -->
            <div class="pointer-events-none hidden group-hover:block absolute z-50 w-48 px- py-1
                      bottom-full left-1/2 -translate-x-1/2 mb-2
                      text-sm text-white bg-gray-900 rounded
                      before:content-[''] before:absolute before:left-1/2 before:-translate-x-1/2
                      before:top-full before:border-4 before:border-transparent
                      before:border-t-gray-900">
                {{ __('messages.showHidePurchaseCode') }}
            </div>
        </button>

        <button type="button" class="text-blue-600 hover:text-blue-700 rounded-lg verify-module group relative"
                data-module="{{ strtolower($module) }}">

            <svg class="icon w-4 h-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
            xmlns="http://www.w3.org/2000/svg"
            width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>

            <!-- Tooltip -->
            <div class="pointer-events-none hidden group-hover:block absolute z-50 w-48  py-1
                      bottom-full left-1/2 -translate-x-1/2 mb-2
                      text-sm text-white bg-gray-900 rounded
                      before:content-[''] before:absolute before:left-1/2 before:-translate-x-1/2
                      before:top-full before:border-4 before:border-transparent
                      before:border-t-gray-900">
                {{ __('messages.changePurchaseCode') }}
            </div>
        </button>
    </div>
@else
    <button type="button" class="text-blue-600 hover:text-blue-800 underline inline-flex items-center verify-module" data-module="{{ strtolower($module) }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
        @lang('app.verifyEnvato')
    </button>
@endif

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
