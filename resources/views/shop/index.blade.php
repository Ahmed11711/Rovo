@extends('layouts.guest')

@section('content')

@livewire('shop.cart', ['tableID' => $tableHash ?? null, 'restaurant' => $restaurant ?? null, 'shopBranch' => $shopBranch ?? null , 'getTable' => $getTable ?? false, 'canCreateOrder'=> $canCreateOrder])

@livewire('customer.signup', ['restaurant' => $restaurant])

@endsection
