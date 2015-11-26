@extends('layouts.master')

@section('title', $guide->title)

@section('content')

    {{ $guide->description }}

    <hr>

    <div class="col-md-8 sortable">
        @each('pages.resources.guides._step', $guide->steps, 'step')
    </div>

    <div class="col-md-3">
        <p>
            <span class="btn-group">
                 <a href="{{ route('resources.guides.steps.index', [$guide->getSlug()]) }}" class="btn btn-primary">
                     Steps
                 </a>
                <a href="{{ route('resources.guides.steps.create', [$guide->getSlug()]) }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                </a>
            </span>
        </p>

        <p>
            <a href="{{ route('resources.guides.edit', [$guide->getSlug()]) }}" class="btn btn-warning">
                Edit
            </a>
            <a href="{{ route('resources.guides.destroy', [$guide->getSlug()]) }}"
               class="btn btn-danger"
               data-post="DELETE"
               data-title="Delete Guide?"
               data-message="Are you sure you want to delete this guide? It cannot be recovered."
            >
                Delete
            </a>
        </p>
    </div>

@stop
