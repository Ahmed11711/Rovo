@if ($type == 'info')
    @php
        $typeClass = 'text-blue-800 border border-blue-300 bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800';
    @endphp
@elseif($type == 'danger')
    @php
    $typeClass = 'text-red-800 border border-red-300 bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800';
    @endphp
@elseif($type == 'warning')
    @php
    $typeClass = 'text-yellow-800 border border-yellow-300 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800';
    @endphp
@elseif($type == 'success')
    @php
    $typeClass = 'text-green-800 border border-green-300 bg-green-50 dark:bg-gray-800 dark:text-green-300 dark:border-green-800';
    @endphp
@else
    @php
    $typeClass = 'text-gray-800 border border-gray-300 bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600';
    @endphp
@endif

<div {{ $attributes->merge(['class' => 'flex w-full items-center p-4 mb-4 text-sm rounded-lg ' . $typeClass]) }}


    role="alert">

        {{ $slot }}
</div>

