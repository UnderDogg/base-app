@extends('layouts.master')

@section('title', 'All Tickets')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $issues !!}

@endsection
