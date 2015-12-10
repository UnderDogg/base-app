@extends('layouts.master')

@section('title', 'All Users')

@section('content')

    @decorator('navbar', $navbar)

    {!! $users !!}

@endsection
