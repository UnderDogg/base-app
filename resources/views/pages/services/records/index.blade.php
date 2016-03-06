@extends('layouts.master')

@section('title', "$service->name Service Records")

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $records !!}

@endsection
