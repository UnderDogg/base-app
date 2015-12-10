@extends('layouts.master')

@section('title', 'All Issues')

@section('content')

    @decorator('navbar', $navbar)

    {!! $issues !!}

@endsection
