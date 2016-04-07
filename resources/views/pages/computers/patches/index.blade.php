@extends('layouts.master')

@section('title', "Patches for {$computer->name}")

@section('title.header')

    <a href="{{ route('computers.show', [$computer->id]) }}" class="btn btn-primary">
        <i class="fa fa-caret-left"></i>
        Back To {{ $computer->name }}
    </a>

    <hr>

@endsection

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $patches !!}

@endsection
