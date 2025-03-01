@extends('layouts.guest')

@section('content')

@livewire('shop.bookATable', ['restaurant' => $restaurant])

@livewire('customer.signup', ['restaurant' => $restaurant])

@endsection