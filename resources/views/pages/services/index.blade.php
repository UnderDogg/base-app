@extends('layouts.master')

@section('title', 'All Services')

@section('content')

    @decorator('navbar', $navbar)

    {!! $services !!}

@endsection
