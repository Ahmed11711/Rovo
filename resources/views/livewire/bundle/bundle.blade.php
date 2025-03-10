<div x-data="{ showModal: @entangle('showAddBundleModal') }">
    <div class="p-4 bg-white flex items-center justify-between dark:bg-gray-800 dark:border-gray-700">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('All Bundles')</h1>
        <x-button type='button' wire:click="$set('showAddBundleModal', true)">@lang('Create Bundle')</x-button>
    </div>

    <div class="flex flex-col mt-4">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Name</th>
                                <th class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Description</th>
                                <th class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Price</th>
                                <th class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Available</th>
                                <th class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Products</th>
                                <th class="py-2.5 px-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($bundles as $bundle)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2.5 px-4 text-gray-900 dark:text-white">{{ $bundle->name }}</td>
                                <td class="py-2.5 px-4 text-gray-900 dark:text-white">{{ $bundle->desc }}</td>
                                <td class="py-2.5 px-4 text-gray-900 dark:text-white">${{ number_format($bundle->price, 2) }}</td>
                                <td class="py-2.5 px-4 text-gray-900 dark:text-white">{{ $bundle->is_available ? 'Yes' : 'No' }}</td>
                                <td class="py-2.5 px-4 text-gray-900 dark:text-white">
                                    @foreach ($bundle->products as $product)
                                        <div>{{ $product->menu_name }} - {{ $product->pivot->quantity }}</div>
                                    @endforeach
                                </td>
                                <td class="py-2.5 px-4 space-x-2 text-right">
                                    <x-secondary-button-table wire:click='showEditBundle({{ $bundle->id }})'>@lang('Edit')</x-secondary-button-table>
                                    <x-danger-button-table wire:click='showDeleteBundle({{ $bundle->id }})'>@lang('Delete')</x-danger-button-table>
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 text-white dark:hover:bg-gray-700 text-center font-bold">
                                <td class="py-2.5 px-4 space-x-6" colspan="6">@lang('No bundles available.')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-right-modal wire:model.live="showAddBundleModal">
        <x-slot name="title">
            @lang('Create Bundle')
        </x-slot>
        <x-slot name="content">
            <form wire:submit.prevent="submitForm">
                <div class="space-y-4">
                    <div>
                        <x-label for="name" value="Name" class="font-semibold" />
                        <x-input id="name" class="block mt-1 w-full" type="text" wire:model='name' placeholder="Enter bundle name..." />
                    </div>
                    <div>
                        <x-label for="desc" value="Description" class="font-semibold" />
                        <x-textarea id="desc" class="block mt-1 w-full" wire:model='desc' placeholder="Enter bundle description..."></x-textarea>
                    </div>
                    <div>
                        <x-label for="price" value="Price" class="font-semibold" />
                        <x-input id="price" class="block mt-1 w-full" type="number" step="0.01" wire:model='price' placeholder="Enter price..." />
                    </div>
                    <div>
                        <x-label for="products" value="Products" class="font-semibold" />
                        <div class="border rounded-lg p-3 bg-gray-50 dark:bg-gray-700">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-700 dark:text-gray-300">
                                        <th class="p-2">@lang('Select')</th>
                                        <th class="p-2">@lang('Product Name')</th>
                                        <th class="p-2">@lang('Quantity')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <td class="p-2">
                                                <input type="checkbox" wire:model="selectedProducts.{{ $product->id }}">
                                            </td>
                                            <td class="p-2">{{ $product->menu_name }}</td>
                                            <td class="p-2">
                                                <x-input
                                                    type="number"
                                                    wire:model="selectedProductsQuantities.{{ $product->id }}"
                                                    placeholder="Qty"
                                                    class="w-20"
                                                    min="1"
                                                    wire:disabled="!isset($selectedProducts[$product->id])"
                                                />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-6">
                    <x-button type="submit">Save</x-button>
                    <x-button-cancel type="button" wire:click="$set('showAddBundleModal', false)" wire:loading.attr="disabled">@lang('Cancel')</x-button-cancel>
                </div>
            </form>
        </x-slot>
    </x-right-modal>
</div>
