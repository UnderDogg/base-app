@extends('layouts.master')

@section('title', 'All Devices')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $computers !!}

@endsection
