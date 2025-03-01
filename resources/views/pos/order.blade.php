@extends('layouts.app')

@section('content')

<livewire:pos.pos orderDetail="true" :$tableOrderID :key="$tableOrderID">
    
@endsection