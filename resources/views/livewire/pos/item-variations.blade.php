<div>
    <div class="flex flex-col">
        <div class="flex gap-4 mb-4">
            <img class="w-16 h-16 rounded-md  object-cover" src="{{ $menuItem->item_photo_url }}" alt="{{ $menuItem->item_name }}">
            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                <div class="text-base font-semibold text-gray-900 dark:text-white inline-flex items-center">
                    <img src="{{ asset('img/'.$menuItem->type.'.svg')}}" class="h-4 mr-2"
                        title="@lang('modules.menu.' . $menuItem->type)" alt="" />
                    {{ $menuItem->item_name }}
                </div>
                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{
                    $menuItem->description }}</div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.itemName')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    @lang('modules.menu.setPrice')
                                </th>
                                <th scope="col"
                                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                                    @lang('app.action')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                            wire:key='menu-item-list-{{ microtime() }}'>

                            @foreach ($menuItem->variations as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                wire:key='menu-item-{{ $item->id . microtime() }}'>
                                <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base text-gray-900 dark:text-white inline-flex items-center">
                                            {{ $item->variation }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->price ? currency_format($item->price, $item->menuItem->branch->restaurant->currency_id) : '--' }}
                                </td>


                                <td class="py-2.5 px-4 space-x-2 whitespace-nowrap text-right">
                                    <x-button wire:click='setItemVariation({{ $item->id }})'  wire:key='del-var-btn-{{ $item->id }}'>
                                       @lang('modules.order.select')
                                    </x-button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>