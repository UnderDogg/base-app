@extends('layouts.master')

@section('title.header')
    <h2>
        @section('title') Create Step {{ $steps }} @show
    </h2>
@stop

@section('content')

    {!! $form !!}

@stop
