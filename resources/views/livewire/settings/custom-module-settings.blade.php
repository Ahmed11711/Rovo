<div>

    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th scope="col"
                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    @lang('app.name')
                </th>
                <th scope="col"
                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    @lang('app.purchaseCode')
                </th>
                <th scope="col"
                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    @lang('app.notify')
                </th>
                <th scope="col"
                    class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                    @lang('app.status')
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='member-list-{{ microtime() }}'>
            @forelse ($allModules as $key=>$module)
                @php
                    $fetchSetting = null;
                    if (in_array($module, $customPlugins) && config(strtolower($module) . '.setting'))
                    {
                        $fetchSetting = config(strtolower($module) . '.setting')::first();
                    }
                @endphp

                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='module-{{ rand(1111, 9999) . microtime() }}' wire:loading.class.delay='opacity-10'>
                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $key }}
                    </td>
                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                        {{ '--' }}
                    </td>
                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-skin-base"></div>
                        </label>
                    </td>
                    <td class="py-2.5 px-4 text-base text-gray-900 whitespace-nowrap dark:text-white text-right">

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-skin-base"></div>
                        </label>

                    </td>
                </tr>
            @empty
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="py-2.5 px-4 space-x-6" colspan="5">
                    @lang('messages.noRecordFound')
                </td>
            </tr>
            @endforelse
</div>
