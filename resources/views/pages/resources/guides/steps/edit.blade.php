@extends('layouts.app')

@section('extra.top')
    <a class="btn btn-primary" href="{{ route('resources.guides.show', [$guide->slug]) }}">
        <i class="fa fa-caret-left"></i>
        Back to Guide
    </a>
@endsection

@section('title', 'Edit Step')

@section('content')

    {!! $form !!}

@endsection
