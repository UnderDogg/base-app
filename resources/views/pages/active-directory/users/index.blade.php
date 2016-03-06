@extends('layouts.master')

@section('title', 'All Users')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $users !!}

@endsection
