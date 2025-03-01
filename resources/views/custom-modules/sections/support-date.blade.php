@php $supportDate = \Carbon\Carbon::parse($fetchSetting->supported_until) @endphp

@if ($supportDate->isPast())
    <span>Your support has been expired on <b>{{ $supportDate->translatedFormat('d M, Y') }}</b>
        @if($supportDate->isYesterday())
            (Yesterday)
        @endif
    </span>
    <br>
@else
    <span>Your support will expire on <b>{{ $supportDate->translatedFormat('d M, Y') }}</b>
        @if($supportDate->isToday())
            (Today)
        @elseif($supportDate->isTomorrow())
            (Tomorrow)
        @endif
    </span>
    @if((int)now()->diffInDays($supportDate) < 90)
        @livewire('support-date-modal')
    @endif
@endif



