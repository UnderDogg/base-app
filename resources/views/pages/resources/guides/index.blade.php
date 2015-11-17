@extends('layouts.master')

@section('title', 'All Guides')

@section('content')

    @decorator('navbar', $navbar)

    {!! $guides !!}

@stop
