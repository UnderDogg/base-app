@extends('layouts.master')

@section('title', 'All Services')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $services !!}

@endsection
