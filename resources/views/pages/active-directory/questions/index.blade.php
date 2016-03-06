@extends('layouts.master')

@section('title', 'All Security Questions')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $questions !!}

@endsection
