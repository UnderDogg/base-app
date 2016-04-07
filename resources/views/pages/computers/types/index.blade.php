@extends('layouts.master')

@section('title', 'All Computer Types')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $types !!}

    </div>

@endsection
