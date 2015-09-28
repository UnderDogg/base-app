@extends('layouts.master')

@section('title', 'All Computers')

@section('content')

    @decorator('navbar', $navbar)

    {!! $computers !!}

@stop
