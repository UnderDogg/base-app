@extends('layouts.master')

@section('title', 'All Patches')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $patches !!}

@endsection
