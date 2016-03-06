@extends('layouts.master')

@section('title', 'All Guides')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $guides !!}

@endsection
