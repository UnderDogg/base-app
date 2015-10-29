@extends('layouts.master')

@section('title', 'All Security Questions')

@section('content')

    @decorator('navbar', $navbar)

    {!! $questions !!}

@stop
