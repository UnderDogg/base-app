@extends('layouts.master')

@section('title', 'Setup Passwords')

@section('title.header')
    <h3 class="text-center">
        @yield('title')
    </h3>
@endsection

@section('content')

    <div class="col-md-3"></div>

    <div class="col-md-6 text-center">
        <i class="fa fa-6 fa-lock"></i>

        <div class="alert alert-info" role="alert">
            <b>Hey There.</b>

            <p>
                You have to create a pin before you can start storing passwords.
            </p>

            <p>
                All encrypted usernames, passwords, and notes are encrypted using OpenSSL and the AES-256-CBC cipher.
                Furthermore, all encrypted values are signed with a message authentication
                code (MAC) to detect any modifications to the encrypted string.
            </p>

        </div>
    </div>

    <div class="col-md-3"></div>

    <div class="clearfix"></div>

    {!! $form !!}

@endsection
