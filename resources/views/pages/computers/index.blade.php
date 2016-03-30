@extends('layouts.master')

@section('title', 'All Devices')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $computers !!}

@endsection
