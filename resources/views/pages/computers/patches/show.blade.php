@extends('layouts.master')

@section('title', $patch->title)

@section('title.header')

    <a href="{{ route('computers.patches.index', [$computer->getKey()]) }}" class="btn btn-primary">
        <i class="fa fa-caret-left"></i>
        Back To Patches
    </a>

    <hr>

@endsection

@section('content')

    {!! Decorator::render('navbar', $navbar) !!}

    <div class="well">
        {!! $patch->description_from_markdown  !!}
    </div>

@endsection
