@extends('layouts.master')

@section('title', 'All Computer Types')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $types !!}

@endsection
