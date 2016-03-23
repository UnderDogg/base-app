@extends('layouts.master')

@section('title', "Patches for {$computer->name}")

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $patches !!}

@endsection
