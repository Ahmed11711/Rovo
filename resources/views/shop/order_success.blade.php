@extends('layouts.guest')

@section('content')

@livewire('shop.orderSuccess', ['restaurant' => $restaurant, 'id' => $id])
    
@endsection