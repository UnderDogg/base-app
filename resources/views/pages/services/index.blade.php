@extends('layouts.master')

@section('title', 'All Services')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $services !!}

@endsection
