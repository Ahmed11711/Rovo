@extends('layouts.app')

@section('content')

@livewire('Restaurant.RestaurantDetail', ['hash' => $id])

@endsection