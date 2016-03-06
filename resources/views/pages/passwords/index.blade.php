@extends('layouts.master')

@section('title', 'All Passwords')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $passwords !!}

@endsection
