@extends('layouts.master')

@section('title', 'All Requests')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $inquiries !!}

    </div>

@endsection
