@extends('layouts.master')

@if($category->exists)
    @section('title', "All Categories under $category->name")
@else
    @section('title', 'All Categories')
@endif

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    {!! $categories !!}

@endsection
