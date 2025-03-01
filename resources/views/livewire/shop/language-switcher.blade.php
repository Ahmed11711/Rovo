<div>
    <button type="button" data-dropdown-toggle="language-dropdown"
        class="inline-flex justify-center  text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white ">
        {{isset(\App\Models\LanguageSetting::LANGUAGES_TRANS[$activeLanguage->language_code]) ? \App\Models\LanguageSetting::LANGUAGES_TRANS[$activeLanguage->language_code] : $activeLanguage->language_name}}
    </button>
    <!-- Dropdown -->
    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700"
        id="language-dropdown">
        <ul class="py-1" role="none">

            @foreach (languages() as $item)
            <li wire:key='language-{{ $item->id }}'>
                <a href="javascript:;" wire:click="setLanguage('{{ $item->language_code }}')"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">
                    <div class="inline-flex items-center">
                        <img class="h-3.5 w-3.5 rounded-full ltr:mr-2 rtl:ml-2" src="{{$item->flagUrl}}" alt="">
                        {{\App\Models\LanguageSetting::LANGUAGES_TRANS[$item->language_code] ?? $item->language_name}}
                    </div>
                </a>
            </li>
            @endforeach

        </ul>
    </div>
</div>
