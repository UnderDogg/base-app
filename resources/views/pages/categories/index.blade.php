@extends('layouts.app')

@if($category->exists)
    @section('title', "All Categories under $category->name")
@else
    @section('title', 'All Categories')
@endif

@section('title.header', ' ')

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="panel panel-default">

        {!! $categories !!}

    </div>

@endsection
