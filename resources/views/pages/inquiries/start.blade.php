@extends('layouts.app')

@section('title', 'Select a Request Category')

@section('content')

    <div class="panel panel-default">

        {!! $categories !!}

    </div>

@endsection
