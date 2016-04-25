@extends('layouts.app')

@section('title.header')

    <h3>@section('title') Setup Security Questions @show</h3>

    <span class="text-muted">(Question {{ $step }} of 3)</span>

@endsection

@section('content')

    {!! $form !!}

@endsection
