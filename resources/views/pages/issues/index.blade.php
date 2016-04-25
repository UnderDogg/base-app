@extends('layouts.app')

@section('title', 'All Tickets')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $issues !!}

    </div>


@endsection
