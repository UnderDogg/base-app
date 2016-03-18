@extends('layouts.master')

@section('title', 'All Security Questions')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $questions !!}

@endsection
