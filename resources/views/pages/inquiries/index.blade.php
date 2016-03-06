@extends('layouts.master')

@section('title', 'All Requests')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $inquiries !!}

@endsection
