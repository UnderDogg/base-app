@extends('layouts.master')

@section('title', 'All Guides')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $guides !!}

@endsection
