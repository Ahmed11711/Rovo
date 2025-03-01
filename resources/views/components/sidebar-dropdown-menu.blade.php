<li>
    <button type="button"
        @class(['flex items-center w-full p-2 text-base transition duration-75 rounded-xl group hover:bg-gray-200 dark:text-gray-200 dark:hover:bg-gray-700', 'hover:text-gray-800 text-white font-bold bg-gray-700' => $active])
        aria-controls="dropdown-{{ \Str::slug($name) }}" data-collapse-toggle="dropdown-{{ \Str::slug($name) }}">
        {!! $customIcon ?? $icon !!}
        @if ($isAddon && !app()->environment('codecanyon'))
            <span class="flex-1 ltr:ml-3 rtl:mr-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $name }} 
                <span x-data="{ tooltip: false }" 
                      @mouseenter="tooltip = true" 
                      @mouseleave="tooltip = false"
                      class="bg-yellow-400 text-white px-2 py-1 rounded-md text-xs inline-flex cursor-help">
                    @lang('app.addon')
                    <div x-show="tooltip" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 transform scale-95" 
                         x-transition:enter-end="opacity-100 transform scale-100" 
                         x-transition:leave="transition ease-in duration-100" 
                         x-transition:leave-start="opacity-100 transform scale-100" 
                         x-transition:leave-end="opacity-0 transform scale-95" 
                         class="fixed z-50"
                         x-cloak
                         @mouseenter="tooltip = true"
                         x-init="$watch('tooltip', value => {
                             if (value) {
                                 let parent = $el.parentElement;
                                 let rect = parent.getBoundingClientRect();
                                 $el.style.left = `${rect.left + (rect.width / 2)}px`;
                                 $el.style.top = `${rect.top - 10}px`;
                             }
                         })"
                         style="display: none;">
                        <div class="bg-gray-900 text-white text-sm px-4 py-2 rounded-lg shadow-lg transform -translate-x-1/2 -translate-y-full min-w-[200px] max-w-[300px]">
                            <span class="block whitespace-normal leading-relaxed">@lang('messages.addonDescription')</span>
                            <div class="absolute w-3 h-3 bg-gray-900 transform rotate-45 left-1/2 -translate-x-1/2 -bottom-1.5"></div>
                        </div>
                    </div>
                </span>
            </span>
        @else
            <span class="flex-1 ltr:ml-3 rtl:mr-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $name }}</span>
        @endif
        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
    <ul id="dropdown-{{ \Str::slug($name) }}" @class(['py-2 space-y-2', 'hidden' => !$active])>
        {{ $slot }}
    </ul>
</li>