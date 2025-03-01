@extends('layouts.app')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endpush

@section('content')

@livewire('settings.master')


@endsection

@push('scripts')
<script>
    function form() {
        var element = document.querySelector("trix-editor");

        return {
            save() {
                let that = this;
                let myPromise = new Promise(function(myResolve, myReject) {

                    Livewire.dispatch('alpine-save', {description: that.$refs.description.value});

                    setTimeout(() => {
                        myResolve(); // when successful
                    }, 100);

                });

                // "Consuming Code" (Must wait for a fulfilled Promise)
                myPromise.then(
                    function (value) {
                        that.$wire.call('submitForm');
                    }
                );
            }
        }
    }

</script>
@endpush