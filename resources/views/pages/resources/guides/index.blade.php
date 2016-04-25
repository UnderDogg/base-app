@extends('layouts.app')

@section('title', 'All Guides')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $guides !!}

    </div>

@endsection
