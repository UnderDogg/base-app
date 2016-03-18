@extends('layouts.master')

@section('title', 'All Requests')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $inquiries !!}

@endsection
