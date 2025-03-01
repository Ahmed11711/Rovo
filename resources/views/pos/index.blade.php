@extends('layouts.app')

@section('content')

@livewire('pos.pos')

<!-- Product Drawer -->
<x-right-drawer :title='__("modules.menu.addMenu")'>
    @livewire('forms.addTable')
</x-right-drawer>

    
@endsection