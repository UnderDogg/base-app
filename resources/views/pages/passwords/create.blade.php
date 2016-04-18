@extends('layouts.panel')

@section('title', 'Create a Password')

@section('title.header', ' ')

@section('panel.title')

    Create a Password

    <span class="pull-right text-muted">
        <i class="fa fa-lock"></i>
    </span>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
