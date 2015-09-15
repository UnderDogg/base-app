@extends('layouts.master')

@section('title', 'Login')

@section('content')

    <div class="col-md-3"></div>

    <div class="col-md-6">
        <h2 class="text-center">Login</h2>

        {!!
            Form::open([
                'url' => route('auth.login.perform'),
                'class' => 'form-horizontal',
            ])
        !!}

        @include('auth.login.form')

        {!! Form::close() !!}

    </div>

    <div class="col-md-3"></div>

@stop
