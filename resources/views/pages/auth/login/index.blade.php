@extends('layouts.jumbotron')

@section('title', 'Login')

@section('content')

    <div class="col-md-3"></div>

    <div class="col-md-6 text-white">

        <h2 class="text-center">
            Login
        </h2>

        <p class="text-muted text-center">Using your windows credentials.</p>

        {!! $form !!}

        <p class="text-center">
            <br>
            <a href="{{ route('auth.forgot-password.discover') }}">Forgot Your Password?</a>
        </p>

    </div>

    <div class="col-md-3"></div>

@endsection
