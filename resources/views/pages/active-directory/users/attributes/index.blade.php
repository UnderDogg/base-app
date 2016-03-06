@extends('layouts.master')

@inject('formbuilder', 'form')

@section('title', $user->getName())

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $attributes !!}

@endsection
