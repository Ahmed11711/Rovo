<div class="flex flex-col bg-gray-50 lg:h-full w-full py-4 px-3 dark:bg-gray-900">
    {{-- Search and Reset Section --}}
    <div class="flex items-center justify-between gap-3">
        <div class="flex-1">
            <form action="#" method="GET">
                <label for="products-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <x-input class="block w-full pl-10 pr-3 py-2 border-gray-200 rounded-lg text-sm" type="text"
                        placeholder="{{ __('placeholders.searchMenuItems') }}"
                        wire:model.live.debounce.500ms="search" />
                </div>
            </form>
        </div>

        <x-secondary-link href="{{ route('pos.index') }}" wire:navigate 
            class="inline-flex items-center px-3 py-2 gap-1 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
            </svg>
            @lang('app.reset')
        </x-secondary-link>
    </div>

    {{-- Categories Section --}}
    <div class="flex gap-2 mt-4 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 flex-wrap">
        <button wire:click="$set('filterCategories', null)" @class([
            'px-3 py-1.5 text-sm font-medium rounded-lg whitespace-nowrap',
            'bg-gray-900 text-white dark:bg-white dark:text-gray-900' => is_null($filterCategories),
            'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700' => !is_null($filterCategories),
        ])>
            @lang('app.showAll')
        </button>
        @foreach ($categoryList as $value)
            <button wire:click="$set('filterCategories', {{ $value->id }})" @class([
                'px-3 py-1.5 text-sm font-medium rounded-lg whitespace-nowrap',
                'bg-gray-900 text-white dark:bg-white dark:text-gray-900' => $filterCategories == $value->id,
                'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700' => $filterCategories != $value->id,
            ])>
                {{ $value->category_name }}
            </button>
        @endforeach
    </div>

    {{-- Menu Items Grid --}}
    <div class="mt-4">
        <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3">
            @forelse ($menuItems as $item)
                <li class="group">
                    <input type="checkbox" id="item-{{ $item->id }}" value="{{ $item->id }}"
                        wire:click='addCartItems({{ $item->id }}, {{ $item->variations_count }}, {{ $item->modifier_groups_count }})'
                        wire:key='item-input-{{ $item->id . microtime() }}' class="hidden peer">
                    <label for="item-{{ $item->id }}"
                        class="block w-full bg-white rounded-lg shadow-sm transition-all duration-200 cursor-pointer 
                        hover:shadow-md dark:bg-gray-800 dark:border-gray-700 
                        peer-checked:ring-2 peer-checked:ring-skin-base">
                        {{-- Image Section --}}
                        <div class="relative aspect-square">
                            <img class="w-full h-full object-cover rounded-t-lg"
                                src="{{ $item->item_photo_url }}" 
                                alt="{{ $item->item_name }}" />
                            <span class="absolute top-1 right-1 bg-white/90 dark:bg-gray-800/90 rounded-full p-1 shadow-sm">
                                <img src="{{ asset('img/' . $item->type . '.svg') }}"
                                    class="h-4 w-4" title="@lang('modules.menu.' . $item->type)"
                                    alt="" />
                            </span>
                        </div>

                        {{-- Content Section --}}
                        <div class="p-2">
                            <h5 class="text-sm font-medium text-gray-900 dark:text-white min-h-[2.5rem]">
                                {{ $item->item_name }}
                            </h5>
                            
                            <div class="mt-1 flex items-center justify-between gap-2">
                                @if ($item->variations_count == 0)
                                    <span class="text-base font-semibold text-gray-900 dark:text-white">
                                        {{ currency_format($item->price, restaurant()->currency_id) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-600 dark:text-gray-300 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                        @lang('modules.menu.showVariations')
                                    </span>
                                @endif
                            </div>
                        </div>
                    </label>
                </li>
            @empty
                <li class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <p>@lang('messages.noItemAdded')</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
