@extends('vendor.installer.layouts.master')

@section('title', trans('installer_messages.final.title'))
@section('container')
    <p @class([
            'alert alert-success',
            'alert-danger'=> session()->has('message') && session('message')['status'] !=='success',
        ])
       style="text-align: center;">
        {{ session()->has('message') ? session('message')['message']:trans('installer_messages.final.finished') }}
    </p>
    @if(session()->has('message') && session('message')['status'] =='success')
    <div @class([
            'alert alert-success',
            'alert-danger'=> session()->has('message') && session('message')['status'] !=='success',
        ])
       >
        <h6 style="margin-top: unset;text-align: center">Superadmin login details</h6>
        <table >
            <tr>
                <td style="text-align: right">Email:</td>
                <td style="text-align: left"><b>superadmin@example.com</b></td>
            </tr>
            <tr>
                <td style="text-align: right">Password:</td>
                <td style="text-align: left"><b>123456</b></td>
            </tr>
        </table>
    </div>
    @endif
    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer_messages.final.exit') }}</a>
    </div>
@stop
