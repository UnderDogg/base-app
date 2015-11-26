@extends('layouts.master')

@section('title', $guide->title)

@section('content')

    @decorator('navbar', $navbar)

    {{ $guide->description }}

    <hr>

    <div class="col-md-offset-2 col-md-8 sortable">
        @each('pages.resources.guides._step', $guide->steps, 'step')
    </div>

@stop
