@extends('layouts.landing')

@section('content')

    <x-authentication-card-big>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        @livewire('forms.restaurantSignup')

    </x-authentication-card-big>

@endsection
