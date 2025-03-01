@extends('vendor.installer.layouts.master')

@section('title', trans('installer_messages.welcome.title'))
@section('container')
    <p class="paragraph" style="text-align: center;">{{ trans('installer_messages.welcome.message') }}</p>
    <div class="buttons">
        <a href="{{ route('LaravelInstaller::environment') }}" class="button">{{ trans('installer_messages.next') }}</a>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('installer/js/jQuery-2.2.0.min.js') }}"></script>

    <script>
        $('.button').click(function () {
            const button = $('.button');

            const text = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Moving to next step.';

            $(button).addClass('disabled');
            $('#messageWait').show()
            button.html(text);
        });
    </script>
@endsection
