@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-gray-500
focus:ring-gray-500 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-600 dark:focus:ring-gray-600', 'rows' => 5]) !!}>
</textarea>
