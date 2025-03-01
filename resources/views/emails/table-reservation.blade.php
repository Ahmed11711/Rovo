@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('shop_restaurant', ['hash' => $settings->hash])])
{{ $settings->name }}
@endcomponent
@endslot

# {{ __('app.hello') }} {{ $notifiable->name }},

{{ __('email.reservation.text4') }}

## {{ __('email.reservation.text2') }}

**{{ __('modules.customer.name') }}**: {{ $reservation->customer->name }}

**{{ __('app.date') }}**: {{ $reservation->reservation_date_time->format('d M (l)') }}

**{{ __('app.time') }}**: {{ $reservation->reservation_date_time->format('h:i A') }}

**{{ __('modules.reservation.guests') }}**: {{ $reservation->party_size }}

@php
    $actionText = __('email.reservation.action');
    $actionUrl = route('my_bookings', ['hash' => $settings->hash]);
@endphp

@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent

@lang('app.regards'),<br>
{{ $settings->name }}

---
{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all"> {{ $actionUrl }} </span>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
    © {{ date('Y') }} {{ $settings->name }}. All rights reserved.
@endcomponent
@endslot
@endcomponent
