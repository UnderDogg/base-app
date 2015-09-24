@extends('layouts.master')

@section('title', 'All Passwords')

@section('content')

    @decorator('navbar', $navbar)

    {!! $passwords !!}

@stop
