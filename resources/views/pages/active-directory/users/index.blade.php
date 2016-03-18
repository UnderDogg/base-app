@extends('layouts.master')

@section('title', 'All Users')

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $users !!}

@endsection
