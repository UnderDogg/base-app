@extends('layouts.master')

@section('title', 'All Labels')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $labels !!}

@endsection
