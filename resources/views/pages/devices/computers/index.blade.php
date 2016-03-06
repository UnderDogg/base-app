@extends('layouts.master')

@section('title', 'All Computers')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $computers !!}

@endsection
