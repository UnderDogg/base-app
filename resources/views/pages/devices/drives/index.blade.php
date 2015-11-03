@extends('layouts.master')

@section('title', 'All Drives')

@section('content')

    @decorator('navbar', $navbar)

    {!! $drives !!}

@stop
