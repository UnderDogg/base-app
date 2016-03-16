@extends('layouts.master')

@section('title', 'All Operating Systems')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $systems !!}

@endsection
