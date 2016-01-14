@extends('layouts.master')

@inject('formbuilder', 'form')

@section('title', $user->getName())

@section('content')

    {!! $attributes !!}

@endsection
