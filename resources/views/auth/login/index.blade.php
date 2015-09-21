@extends('layouts.master')

@section('title', 'Login')

@section('title.header')
@stop

@section('content')

    <div class="col-md-3"></div>

    <div class="col-md-6">

        <h2 class="text-center">Login</h2>

        {!! $form !!}

    </div>

    <div class="col-md-3"></div>

@stop
