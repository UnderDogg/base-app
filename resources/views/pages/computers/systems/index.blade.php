@extends('layouts.master')

@section('title', 'All Operating Systems')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $systems !!}

    </div>

@endsection
