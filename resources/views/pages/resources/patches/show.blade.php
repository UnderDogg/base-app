@extends('layouts.master')

@section('title.header')

    <a class="btn btn-primary" href="{{ route('resources.patches.index') }}">
        <i class="fa fa-caret-left"></i>
        Back to Patches
    </a>

    <hr>

@endsection

@section('title', $patch->title)

@section('content')

    <!-- Patch -->
    @include('pages.resources.patches._patch')

    <!-- Patch Computers -->
    @include('pages.resources.patches._computers')

@endsection
