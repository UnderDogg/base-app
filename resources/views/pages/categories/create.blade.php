@extends('layouts.master')

@if (isset($category))
    @section('title', "Create a Sub-Category under $category->name")
@else
    @section('title', 'Create a Category')
@endif


@section('content')

    {!! $form !!}

@endsection
