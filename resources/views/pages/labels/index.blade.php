@extends('layouts.app')

@section('title', 'All Labels')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $labels !!}

    </div>

@endsection
