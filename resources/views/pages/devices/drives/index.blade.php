@extends('layouts.master')

@section('title', 'All Drives')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $drives !!}

@endsection
