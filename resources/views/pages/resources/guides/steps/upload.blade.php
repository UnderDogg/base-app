@extends('layouts.master')

@section('extra.top')
    <a class="btn btn-primary" href="{{ route('resources.guides.show', [$guide->slug]) }}">
        <i class="fa fa-caret-left"></i>
        Back to Guide
    </a>
@endsection

@section('title', 'Upload Images')

@section('content')

    {!! $form !!}

@endsection
