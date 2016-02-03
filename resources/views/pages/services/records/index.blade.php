@extends('layouts.master')

@section('title', "$service->name Service Records")

@section('content')

    @decorator('navbar', $navbar)

    {!! $records !!}

@endsection
