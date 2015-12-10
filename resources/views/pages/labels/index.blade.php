@extends('layouts.master')

@section('title', 'All Labels')

@section('content')

    @decorator('navbar', $navbar)

    {!! $labels !!}

@endsection
