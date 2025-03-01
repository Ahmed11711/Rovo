@extends('layouts.guest')

@section('content')


<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 ">
    <div class="mx-auto max-w-screen-lg text-center mb-8 lg:mb-16">
      <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">@lang('modules.settings.aboutUsSettings')</h2>
    </div>

    <div class="bg-gray-100 py-12 px-6 sm:px-12 lg:px-24 rounded-lg">
      <div class="max-w-3xl mx-auto text-center trix-content">
        {!! $restaurant->about_us !!}
      </div>
    </div>

  </div>
</section>

@endsection