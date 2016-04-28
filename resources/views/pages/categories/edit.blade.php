@extends('layouts.panel')

@section('title', 'Edit Category')

@section('title.header', ' ')

@section('panel.title')

    Edit Category

    <span class="pull-right text-muted">
        <i class="fa fa-sitemap"></i>
    </span>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
