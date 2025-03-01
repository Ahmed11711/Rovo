<div>
    <div @class([
        'group flex flex-col gap-3 border bg-white shadow-sm rounded-lg hover:shadow-md transition dark:bg-gray-700 dark:border-gray-600 p-3',
    ]) wire:key='kot-item-{{ $kot->id . microtime() }}'>
        <div class="flex w-full justify-between items-center mb-2">
            <div class="space-y-1">
                <div class="font-semibold text-skin-base">@lang('menu.kot') #{{ $kot->kot_number }}</div>
                <div class="text-sm font-medium text-gray-800 dark:text-neutral-400">
                    {{ $kot->items_count }} @lang('modules.menu.item')
                </div>
            </div>

            <div class="space-y-1 text-right">
                <div class="font-medium text-gray-600 text-sm dark:text-neutral-400">@lang('modules.order.orderNumber')
                    #{{ $kot->order ? $kot->order->order_number : '--' }} @if ($kot->order && $kot->order->table)
                        <span class="text-skin-base font-bold">({{ $kot->order->table->table_code }})</span>
                    @endif
                </div>
                <div class="text-xs text-gray-600 dark:text-neutral-400">
                    {{ $kot->created_at->timezone(timezone())->translatedFormat('F d, H:i A') }}
                </div>
            </div>

        </div>

        <div class="flex justify-between">
            <div class="flex items-center text-gray-600 text-sm gap-1 dark:text-gray-400">
                <svg width="16" height="16" fill="currentColor" viewBox="0 -2.89 122.88 122.88" version="1.1"
                    id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="enable-background:new 0 0 122.88 117.09" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <style type="text/css">
                            .st0 {
                                fill-rule: evenodd;
                                clip-rule: evenodd;
                            }
                        </style>
                        <g>
                            <path class="st0"
                                d="M36.82,107.86L35.65,78.4l13.25-0.53c5.66,0.78,11.39,3.61,17.15,6.92l10.29-0.41c4.67,0.1,7.3,4.72,2.89,8 c-3.5,2.79-8.27,2.83-13.17,2.58c-3.37-0.03-3.34,4.5,0.17,4.37c1.22,0.05,2.54-0.29,3.69-0.34c6.09-0.25,11.06-1.61,13.94-6.55 l1.4-3.66l15.01-8.2c7.56-2.83,12.65,4.3,7.23,10.1c-10.77,8.51-21.2,16.27-32.62,22.09c-8.24,5.47-16.7,5.64-25.34,1.01 L36.82,107.86L36.82,107.86z M29.74,62.97h91.9c0.68,0,1.24,0.57,1.24,1.24v5.41c0,0.67-0.56,1.24-1.24,1.24h-91.9 c-0.68,0-1.24-0.56-1.24-1.24v-5.41C28.5,63.53,29.06,62.97,29.74,62.97L29.74,62.97z M79.26,11.23 c25.16,2.01,46.35,23.16,43.22,48.06l-93.57,0C25.82,34.23,47.09,13.05,72.43,11.2V7.14l-4,0c-0.7,0-1.28-0.58-1.28-1.28V1.28 c0-0.7,0.57-1.28,1.28-1.28h14.72c0.7,0,1.28,0.58,1.28,1.28v4.58c0,0.7-0.58,1.28-1.28,1.28h-3.89L79.26,11.23L79.26,11.23 L79.26,11.23z M0,77.39l31.55-1.66l1.4,35.25L1.4,112.63L0,77.39L0,77.39z">
                            </path>
                        </g>
                    </g>
                </svg>

                {{ $kot->order->waiter->name ?? '--' }}
            </div>

            <div>
                <span @class([
                    'text-xs font-medium px-2 py-1 rounded uppercase tracking-wide whitespace-nowrap ',
                    'bg-yellow-100 text-yellow-800 dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400' =>
                        $kot->status == 'in_kitchen',
                    'bg-blue-100 text-blue-800 dark:bg-gray-700 dark:text-blue-400 border border-blue-400' =>
                        $kot->status == 'food_ready',
                    'bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-400 border border-green-400' =>
                        $kot->status == 'served',
                ])>
                    @lang('modules.order.' . $kot->status)
                </span>
            </div>
        </div>


        <div class="w-full">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 rounded-s-lg">
                            @lang('modules.menu.itemName')
                        </th>
                        <th scope="col" class="px-6 py-3 rounded-e-lg text-right">
                            @lang('modules.order.qty')
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kot->items as $item)
                        <tr class="bg-white dark:bg-gray-800">
                            <td
                                class="flex flex-col px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="text-xs text-gray-900 dark:text-white inline-flex items-center">
                                    {{ $item->menuItem->item_name }}
                                </div>

                                <div class="text-xs text-gray-600 dark:text-white inline-flex items-center">
                                    {{ isset($item->menuItemVariation) ? $item->menuItemVariation->variation : '' }}
                                </div>
                                <!-- Modifiers Section -->
                                @if($item->modifierOptions->isNotEmpty())
                                    @foreach ($item->modifierOptions as $modifier)
                                        <div class="flex items-center text-xs my-1">
                                            <svg class="w-3 h-3 text-gray-800 dark:text-gray-200 me-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                                            </svg>
                                            <span class="text-gray-900 dark:text-gray-200">{{ $modifier->name }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-6 py-2 text-right text-gray-900 dark:text-white">
                                {{ $item->quantity }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($kot->note)
            <div class="w-full bg-orange-50 dark:bg-orange-600 rounded-md p-4 text-sm mb-2">
                <blockquote>
                    <div class="relative z-10">
                        <p class="text-gray-900 dark:text-white"><em>
                                "{{ $kot->note }}"
                            </em></p>
                    </div>
                </blockquote>
            </div>
        @endif

        <div class="flex justify-end gap-2">
          <x-secondary-link href="{{ route('kot.print', $kot->id) }}" target="_blank" class="flex justify-center items-center">
            <svg class="h-10 w-10 text-skin-base" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 13.5H18.5C19.4428 13.5 19.9142 13.5 20.2071 13.2071C20.5 12.9142 20.5 12.4428 20.5 11.5V10.5C20.5 8.61438 20.5 7.67157 19.9142 7.08579C19.3284 6.5 18.3856 6.5 16.5 6.5H7.5C5.61438 6.5 4.67157 6.5 4.08579 7.08579C3.5 7.67157 3.5 8.61438 3.5 10.5V12.5C3.5 12.9714 3.5 13.2071 3.64645 13.3536C3.79289 13.5 4.0286 13.5 4.5 13.5H6" stroke="currentColor"></path> <path d="M6.5 19.8063L6.5 11.5C6.5 10.5572 6.5 10.0858 6.79289 9.79289C7.08579 9.5 7.55719 9.5 8.5 9.5L15.5 9.5C16.4428 9.5 16.9142 9.5 17.2071 9.79289C17.5 10.0858 17.5 10.5572 17.5 11.5L17.5 19.8063C17.5 20.1228 17.5 20.2811 17.3962 20.356C17.2924 20.4308 17.1422 20.3807 16.8419 20.2806L14.6738 19.5579C14.5878 19.5293 14.5448 19.5149 14.5005 19.5162C14.4561 19.5175 14.4141 19.5344 14.3299 19.568L12.1857 20.4257C12.094 20.4624 12.0481 20.4807 12 20.4807C11.9519 20.4807 11.906 20.4624 11.8143 20.4257L9.67005 19.568C9.58592 19.5344 9.54385 19.5175 9.49952 19.5162C9.45519 19.5149 9.41221 19.5293 9.32625 19.5579L7.15811 20.2806C6.8578 20.3807 6.70764 20.4308 6.60382 20.356C6.5 20.2811 6.5 20.1228 6.5 19.8063Z" stroke="currentColor"></path> <path d="M9.5 13.5L13.5 13.5" stroke="currentColor" stroke-linecap="round"></path> <path d="M9.5 16.5L14.5 16.5" stroke="currentColor" stroke-linecap="round"></path> <path d="M17.5 6.5V6.1C17.5 4.40294 17.5 3.55442 16.9728 3.02721C16.4456 2.5 15.5971 2.5 13.9 2.5H10.1C8.40294 2.5 7.55442 2.5 7.02721 3.02721C6.5 3.55442 6.5 4.40294 6.5 6.1V6.5" stroke="currentColor"></path> </g></svg>
</x-secondary-link>



            @if ($kot->status == 'in_kitchen')
                <x-secondary-button wire:click="changeKotStatus('food_ready')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check2-circle mr-1 text-green-600" viewBox="0 0 16 16">
                        <path
                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                        <path
                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                    </svg>

                    @lang('modules.order.food_ready')
                </x-secondary-button>
            @endif

            @if ($kot->status == 'food_ready')
                <x-secondary-button wire:click="changeKotStatus('served')">
                    <svg fill="currentColor" width="16" height="16" version="1.1" id="Capa_1"
                        class="mr-1 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 600.801 600.801" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path
                                        d="M542.166,229.165H58.635c-16.279,0-31.914,6.892-42.895,18.908C4.737,260.114-0.732,276.345,0.734,292.604 c4.154,46.036,22.405,90.355,52.781,128.167c25.49,31.73,59.006,58.253,97.644,77.397c4.708,27.366,28.61,48.254,57.299,48.254 h183.886c28.689,0,52.592-20.888,57.299-48.254c38.637-19.145,72.154-45.667,97.645-77.397 c30.375-37.812,48.627-82.131,52.779-128.167c1.467-16.259-4.002-32.49-15.006-44.531 C574.08,236.057,558.445,229.165,542.166,229.165z M407.645,480.168v8.115c0,8.449-6.85,15.3-15.301,15.3H208.458 c-8.45,0-15.3-6.851-15.3-15.3v-8.115c0-6.144-3.687-11.664-9.333-14.085c-53.153-22.79-95.683-60.68-119.677-106.976h472.506 c-23.996,46.296-66.525,84.186-119.678,106.976C411.33,468.504,407.645,474.024,407.645,480.168z M47.994,316.267 c-2.199-8.98-3.75-18.162-4.593-27.511c-0.811-8.986,6.21-16.751,15.234-16.751h483.533c9.023,0,16.045,7.765,15.232,16.751 c-0.842,9.349-2.393,18.53-4.592,27.511H47.994z">
                                    </path>
                                    <path
                                        d="M392.344,546.923H208.458c-28.55,0-52.795-20.349-57.748-48.419c-38.516-19.123-72.255-45.89-97.584-77.419 C22.688,383.196,4.399,338.784,0.236,292.649c-1.479-16.399,4.037-32.77,15.135-44.914c11.075-12.12,26.844-19.071,43.264-19.071 h483.531c16.42,0,32.188,6.951,43.264,19.071c11.098,12.144,16.614,28.514,15.135,44.914 c-4.161,46.133-22.449,90.545-52.888,128.436c-25.327,31.527-59.067,58.294-97.585,77.419 C445.14,526.574,420.895,546.923,392.344,546.923z M58.635,229.665c-16.139,0-31.639,6.833-42.525,18.746 C5.201,260.348-0.222,276.439,1.232,292.56c4.145,45.938,22.359,90.165,52.672,127.898c25.288,31.479,58.995,58.196,97.476,77.263 l0.228,0.113l0.043,0.25c4.769,27.72,28.659,47.839,56.806,47.839h183.886c28.147,0,52.038-20.119,56.806-47.839l0.043-0.25 l0.229-0.113c38.482-19.068,72.189-45.785,97.477-77.263c30.314-37.735,48.527-81.963,52.671-127.898 c1.454-16.12-3.968-32.212-14.877-44.149c-10.886-11.913-26.386-18.746-42.525-18.746H58.635z M392.344,504.083H208.458 c-8.712,0-15.8-7.088-15.8-15.8v-8.115c0-5.925-3.544-11.273-9.03-13.625c-53.362-22.88-95.952-60.953-119.924-107.205 l-0.378-0.73h474.151l-0.378,0.73c-23.974,46.252-66.564,84.325-119.925,107.205c-5.485,2.352-9.029,7.699-9.029,13.625v8.115 C408.145,496.995,401.057,504.083,392.344,504.083z M64.972,359.607c23.935,45.717,66.182,83.349,119.05,106.016 c5.854,2.51,9.636,8.219,9.636,14.545v8.115c0,8.161,6.639,14.8,14.8,14.8h183.886c8.161,0,14.801-6.639,14.801-14.8v-8.115 c0-6.326,3.782-12.035,9.635-14.545c52.867-22.667,95.114-60.299,119.051-106.016H64.972z M553.201,316.767H47.602l-0.094-0.381 c-2.224-9.081-3.773-18.362-4.605-27.585c-0.401-4.446,1.09-8.88,4.092-12.165c3.023-3.309,7.157-5.131,11.64-5.131h483.533 c4.483,0,8.617,1.822,11.641,5.131c3.001,3.285,4.492,7.719,4.09,12.165c-0.83,9.217-2.379,18.498-4.604,27.585L553.201,316.767z M48.387,315.767h504.029c2.163-8.916,3.673-18.017,4.486-27.056c0.377-4.167-1.021-8.322-3.832-11.4 c-2.832-3.1-6.704-4.806-10.902-4.806H58.635c-4.198,0-8.07,1.707-10.902,4.806c-2.812,3.078-4.21,7.233-3.834,11.4 C44.715,297.755,46.225,306.855,48.387,315.767z">
                                    </path>
                                </g>
                                <g>
                                    <path
                                        d="M169.734,133.492c-7.951-8.275-22.371-18.139-45.914-18.139c-13.135,0-22.812-4.4-29.586-13.451 c-6.423-8.583-8.701-19.427-8.701-26.104c0-11.792-9.53-21.359-21.309-21.42c-11.956-0.061-21.626,10.078-21.529,22.033 c0.145,17.815,6.566,36.895,17.24,51.158c10.455,13.971,30.025,30.624,63.886,30.624c10.143,0,13.74,3.671,14.922,4.877 c2.687,2.741,4.757,7.714,6.195,12.594c1.904,6.464,7.9,10.859,14.64,10.859h12.664c9.923,0,17.244-9.303,14.864-18.937 C184.358,156.461,179.227,143.371,169.734,133.492z">
                                    </path>
                                    <path
                                        d="M172.242,187.023h-12.664c-6.957,0-13.174-4.613-15.119-11.218c-1.19-4.038-3.21-9.464-6.073-12.385 c-1.147-1.17-4.635-4.727-14.565-4.727c-34.069,0-53.764-16.763-64.287-30.824c-10.712-14.315-17.195-33.551-17.34-51.454 c-0.048-5.95,2.345-11.803,6.565-16.057c4.145-4.179,9.599-6.48,15.358-6.48l0.109,0c12.024,0.062,21.806,9.895,21.806,21.92 c0,6.602,2.253,17.321,8.602,25.805c6.673,8.916,16.22,13.25,29.186,13.25c23.721,0,38.257,9.947,46.274,18.292 c8.056,8.383,13.942,19.931,17.497,34.321c1.169,4.731,0.114,9.648-2.895,13.49C181.678,184.812,177.138,187.023,172.242,187.023z M64.118,54.877c-5.49,0-10.692,2.197-14.648,6.185c-4.034,4.066-6.321,9.66-6.275,15.345 c0.144,17.698,6.551,36.712,17.141,50.862c10.386,13.879,29.831,30.424,63.486,30.424c10.35,0,14.06,3.783,15.278,5.026 c3.008,3.069,5.097,8.657,6.319,12.803c1.821,6.183,7.644,10.501,14.16,10.501h12.664c4.586,0,8.839-2.071,11.667-5.683 c2.817-3.599,3.806-8.203,2.711-12.633c-3.512-14.218-9.314-25.613-17.247-33.869c-7.883-8.205-22.185-17.985-45.554-17.985 c-13.303,0-23.111-4.465-29.987-13.651c-6.496-8.681-8.801-19.649-8.801-26.404c0-11.476-9.336-20.861-20.811-20.92L64.118,54.877 z">
                                    </path>
                                </g>
                                <g>
                                    <path
                                        d="M320.838,133.492c-7.951-8.275-22.371-18.139-45.914-18.139c-13.135,0-22.813-4.4-29.586-13.451 c-6.423-8.583-8.702-19.427-8.702-26.104c0-11.792-9.53-21.359-21.309-21.42c-11.956-0.061-21.625,10.078-21.529,22.033 c0.145,17.815,6.566,36.895,17.24,51.158c10.455,13.97,30.024,30.624,63.885,30.624c10.143,0,13.74,3.671,14.922,4.877 c2.687,2.741,4.757,7.714,6.195,12.594c1.905,6.464,7.902,10.859,14.64,10.859h12.664c9.922,0,17.244-9.303,14.863-18.937 C335.461,156.461,330.33,143.371,320.838,133.492z">
                                    </path>
                                    <path
                                        d="M323.346,187.023h-12.664c-6.956,0-13.173-4.613-15.12-11.218c-1.19-4.037-3.209-9.463-6.073-12.385 c-1.146-1.169-4.633-4.727-14.565-4.727c-34.066,0-53.762-16.763-64.286-30.824c-10.712-14.315-17.195-33.551-17.34-51.454 c-0.048-5.95,2.345-11.803,6.565-16.058c4.145-4.179,9.599-6.48,15.357-6.48l0.109,0c12.024,0.062,21.806,9.895,21.806,21.92 c0,6.601,2.253,17.32,8.602,25.805c6.673,8.916,16.22,13.25,29.186,13.25c23.72,0,38.257,9.947,46.274,18.292 c8.056,8.383,13.941,19.93,17.496,34.321c1.169,4.73,0.114,9.647-2.894,13.489C332.781,184.812,328.242,187.023,323.346,187.023z M215.221,54.877c-5.49,0-10.692,2.196-14.647,6.185c-4.034,4.066-6.321,9.659-6.275,15.345 c0.144,17.698,6.551,36.712,17.141,50.862c10.387,13.879,29.832,30.424,63.485,30.424c10.352,0,14.061,3.784,15.279,5.027 c3.008,3.069,5.096,8.656,6.318,12.803c1.822,6.183,7.645,10.5,14.161,10.5h12.664c4.587,0,8.839-2.072,11.667-5.684 c2.817-3.598,3.806-8.203,2.711-12.632c-3.512-14.218-9.314-25.613-17.246-33.869c-7.884-8.205-22.186-17.985-45.554-17.985 c-13.303,0-23.112-4.465-29.987-13.651c-6.496-8.681-8.801-19.649-8.801-26.404c0-11.476-9.336-20.861-20.811-20.92 L215.221,54.877z">
                                    </path>
                                </g>
                            </g>
                        </g>
                    </svg>

                    @lang('modules.order.served')
                </x-secondary-button>
            @endif

            <x-danger-button wire:click="$toggle('confirmDeleteKotModal')">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                @lang('app.cancel')
            </x-danger-button>

        </div>




    </div>

    <x-confirmation-modal wire:model="confirmDeleteKotModal">
        <x-slot name="title">
            @lang('modules.order.cancelKot')?
        </x-slot>

        <x-slot name="content">
            @lang('modules.order.cancelKotMessage')
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeleteKotModal')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click='deleteKot({{ $kot->id }})' wire:loading.attr="disabled">
                @lang('modules.order.cancelKot')
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

</div>
