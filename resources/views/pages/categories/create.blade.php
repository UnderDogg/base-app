@extends('layouts.panel')

@if (isset($category))
    @section('title', 'Create a Sub-Category')
@else
    @section('title', 'Create a Category')
@endif

@section('title.header', ' ')

@section('panel.title')

    Create Category

    <span class="pull-right text-muted">
        <i class="fa fa-sitemap"></i>
    </span>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
