@extends('layouts.master')

@section('title', $guide->title)

@section('content')

    @if(auth()->check())
        @decorator('navbar', $navbar)
    @endif

    @if ($guide->description)
    <div class="panel panel-default">
        <div class="panel-body">
            <span class="text-muted">Description:</span>
            {{ $guide->description }}
        </div>
    </div>
    @endif

    @if(count($guide->steps) > 0)
        <hr>

        <div class="col-md-offset-2 col-md-8 sortable">
            @each('pages.resources.guides._step', $guide->steps, 'step')
        </div>
    @endif

@endsection
