@extends('layouts.master')

@if($category->exists)
    @section('title', "All Categories under $category->name")
@else
    @section('title', 'All Categories')
@endif

@section('content')

    @decorator('navbar', $navbar)

    {!! $categories !!}

@endsection
