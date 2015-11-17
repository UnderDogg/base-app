@extends('layouts.master')

@section('title', $guide->title)

@section('content')

    {{ $guide->description }}

    <hr>

    <div class="col-md-8">
        @each('pages.resources.guides._step', $guide->steps, 'step')
    </div>

@stop
