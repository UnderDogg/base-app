@extends('layouts.app')

@section('title', 'All Devices')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $computers !!}

    </div>

@endsection
