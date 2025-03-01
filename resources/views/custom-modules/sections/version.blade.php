@if ($plugins->where('envato_id', $envatoId)->first())

    @if ($plugins->where('envato_id', $envatoId)->pluck('version')->first() > \Illuminate\Support\Facades\File::get($module->getPath() . '/version.txt'))

        <span class="px-2 py-1 text-xs font-medium text-white bg-red-500 rounded-full cursor-help"
              x-data="{ tooltip: false }"
              x-on:mouseenter="tooltip = true"
              x-on:mouseleave="tooltip = false"
              x-on:focus="tooltip = true"
              x-on:blur="tooltip = false">
            {{ \Illuminate\Support\Facades\File::get($module->getPath() . '/version.txt') }}

            <div x-show="tooltip"
                 class="absolute z-50 p-2 mt-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg whitespace-normal min-w-[200px] max-w-[300px] break-words"
                 x-cloak
                 role="tooltip">
                @lang('app.moduleUpdateMessage', [
                    'name' => $module->getName(),
                    'version' => $plugins->where('envato_id', $envatoId)->pluck('version')->first(),
                ])
            </div>
        </span>
    @else
        <span class="px-2 py-1 text-xs font-medium text-white bg-green-500 rounded-full">
            {{ \Illuminate\Support\Facades\File::get($module->getPath() . '/version.txt') }}
        </span>
    @endif
@else
    <span class="px-2 py-1 text-xs font-medium text-white bg-green-500 rounded-full">{{ \Illuminate\Support\Facades\File::get($module->getPath() . '/version.txt') }}</span>
@endif
