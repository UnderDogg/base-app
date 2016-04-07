@extends('layouts.master')

@section('title', 'All Services')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $services !!}

    </div>

@endsection
