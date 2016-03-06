@extends('layouts.master')

@section('title', 'All Labels')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $labels !!}

@endsection
