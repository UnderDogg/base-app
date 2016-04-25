@extends('layouts.app')

@section('title', 'All Passwords')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $passwords !!}

    </div>

@endsection
