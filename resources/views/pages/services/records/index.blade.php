@extends('layouts.app')

@section('title', "$service->name Service Records")

@section('title.header')

    <a class="btn btn-primary" href="{{ route('services.index') }}">
        <i class="fa fa-caret-left"></i>
        Back to Services
    </a>

    <hr>

@endsection

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $records !!}

@endsection
