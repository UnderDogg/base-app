@extends('layouts.master')

@section('title.header')

    <h3>@section('title') Setup Security Questions @show</h3>

    <span class="text-muted">(Question {{ $step }} of 3)</span>

@stop

@section('content')

    {!! $form !!}

@stop
