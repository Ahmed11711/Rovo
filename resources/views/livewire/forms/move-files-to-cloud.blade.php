<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-4">

        <x-button type="button" class="flex gap-2"
            wire:click="moveToCloud">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            @lang('modules.settings.moveFilesToCloud')
        </x-button>

        <x-button-cancel class="flex gap-2"
            wire:click="$dispatch('hideMoveFilesToCloudModal')">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            @lang('app.cancel')
        </x-button-cancel>
    </div>

    <!-- Progress Bar - Show when files are being moved -->
    <div wire:loading wire:target="moveToCloud" class="mb-6">
        <div class="relative pt-1">
            <div class="flex mb-2 items-center justify-between">
                <div>
                    <span class="text-xs font-semibold inline-block text-indigo-600">
                        @lang('messages.transferProgress')
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-semibold inline-block text-indigo-600">
                        {{ $progress ?? 0 }}%
                    </span>
                </div>
            </div>
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200">
                <div 
                    style="width: {{ $progress ?? 0 }}%"
                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-600 transition-all duration-500">
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($localFiles as $file)
            <div class="relative group bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 dark:bg-gray-800 dark:border-gray-700">

                <div class="p-2">
                    <div class="flex items-start">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
       
                                <h3 class="text-xs text-gray-900 truncate " title="{{ $file->name }}">
                                    {{ $file->filename }}
                                </h3>
                            </div>
                            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    {{ $file->size_format }}
                                </div>
                                <div class="flex items-center">
                                    @if (strpos($file->type, 'image') !== false)
                                        <img src="{{ asset_url($file->path . '/' . $file->filename) }}" alt="{{ $file->filename }}" class="w-10 h-10 rounded-md">
                                    @else
                                        <a class="underline underline-offset-1" target="_blank" href="{{ asset_url($file->path . '/' . $file->filename) }}">@lang('app.view')</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 p-12">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">@lang('messages.noFilesAvailable')</h3>
                    <p class="mt-1 text-sm text-gray-500">@lang('messages.noFilesAvailableDescription')</p>
                </div>
            </div>
        @endforelse
    </div>
</div>