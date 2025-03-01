@extends('layouts.app')

@section('content')

@livewire('order.Orders', ['orderID' => $id])

    
@endsection