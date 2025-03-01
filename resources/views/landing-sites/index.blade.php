@extends('layouts.app')

@section('content')

<div class="p-4 bg-white block  dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">@lang('menu.landingSites')</h1>
    </div>
</div>

@livewire('forms.DisableLanding', ['settings' => $settings])

@endsection
