@extends('layouts.master')

@section('title', $guide->title)

@section('content')

    {{ $guide->description }}

    <hr>

    <div class="col-md-8 sortable">
        @each('pages.resources.guides._step', $guide->steps, 'step')
    </div>

    <div class="col-md-3">
        <a href="{{ route('resources.guides.steps.index', [$guide->slug]) }}" class="btn btn-primary">
            Steps
        </a>

        <a href="{{ route('resources.guides.edit', [$guide->slug]) }}" class="btn btn-warning">
            Edit
        </a>
        <a href="{{ route('resources.guides.destroy', [$guide->slug]) }}"
           class="btn btn-danger"
           data-post="DELETE"
           data-title="Delete Guide?"
           data-message="Are you sure you want to delete this guide? It cannot be recovered."
        >
            Delete
        </a>
    </div>

@stop
