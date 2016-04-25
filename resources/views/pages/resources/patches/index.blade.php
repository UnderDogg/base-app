@extends('layouts.app')

@section('title', 'All Patches')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $patches !!}

    </div>

@endsection
