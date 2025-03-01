<div class="w-full">

    <button id="changeBranchButtonMobile" data-dropdown-toggle="changeBranchDropdownMobile" class="border-b border-skin-base dark:border-gray-500 font-semibold text-skin-base dark:text-gray-300 text-sm px-2 py-2.5 text-center flex items-center  justify-between gap-2 w-full" type="button">
        
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
        </svg>

        {{ $currentBranch->name }}

        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
    </button>
        
    <!-- Dropdown menu -->
    <div id="changeBranchDropdownMobile" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-52 dark:bg-gray-700 dark:divide-gray-600">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="changeBranchButton">
            @foreach ($restaurant->branches as $item)
            <li>
                <a href="javascript:;" wire:key='branch-{{ $item->id . microtime() }}' wire:click='updateBranch({{ $item->id }})' class="block px-4 py-2.5 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $item->name }}</a>
            </li>
            @endforeach
        </ul>
        
    </div>

</div>
