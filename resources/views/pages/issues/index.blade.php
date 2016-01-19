@extends('layouts.master')

@section('title', 'All Tickets')

@section('content')

    @decorator('navbar', $navbar)

    {!! $issues !!}

@endsection
