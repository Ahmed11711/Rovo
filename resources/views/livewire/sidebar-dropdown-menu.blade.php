<li>
    <a href="{{ $link }}" wire:navigate
        @class(['flex items-center p-2 text-base text-gray-600 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700', 'text-gray-900 font-bold' => $active])>{{ $name }}</a>
</li>
