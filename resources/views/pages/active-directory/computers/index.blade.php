@extends('layouts.master')

@section('title', 'All Computers')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $computers !!}

@endsection
