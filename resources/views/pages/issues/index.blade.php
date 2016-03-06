@extends('layouts.master')

@section('title', 'All Tickets')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $issues !!}

@endsection
