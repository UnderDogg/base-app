@extends('layouts.master')

@section('title.header')

    <h3 class="text-center"> @section('title') Forgot Password @show </h3>

@stop

@section('content')

    <div class="col-md-3"></div>

    <div class="col-md-6">

    {!! $form !!}

    </div>

@stop
