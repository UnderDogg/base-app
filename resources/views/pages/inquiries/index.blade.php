@extends('layouts.master')

@section('title', 'All Requests')

@section('content')

    @decorator('navbar', $navbar)

    {!! $inquiries !!}

@endsection
