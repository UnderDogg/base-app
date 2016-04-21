@extends('layouts.master')

@if (isset($category))
    @section('title', 'Create a Sub-Category')
@else
    @section('title', 'Create a Category')
@endif


@section('content')

    {!! $form !!}

@endsection
