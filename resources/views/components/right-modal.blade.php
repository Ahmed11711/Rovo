@props(['id' => null, 'maxWidth' => null])

@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
][$maxWidth ?? '2xl'];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-40"
    style="display: none;">
    <!-- Overlay -->
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Sliding Modal -->
    <div x-show="show" class="mb-6 bg-white dark:bg-gray-800 overflow-auto shadow-xl transform transition-all fixed top-0 right-0 sm:w-full h-screen {{ $maxWidth }}"
        x-trap.inert.noscroll="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $title }}
            </div>

            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                {{ $content }}
            </div>
        </div>
    </div>
</div>
