<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-2.5 py-1.5 bg-red-100 border border-red-500 rounded-lg font-semibold text-sm text-red-700 hover:bg-red-200 active:bg-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 dark:bg-gray-800']) }}>
    {{ $slot }}
</button>
