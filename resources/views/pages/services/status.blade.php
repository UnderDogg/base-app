@extends('layouts.jumbotron')

@section('title', "$service->name Status")

@section('content')

    <div class="text-center text-white">

        <h1 class="hidden-xs">
            <i class="fa fa-server"></i>
            {{ $service->name }}
        </h1>

        <h2 class="visible-xs">
            <i class="fa fa-server"></i>
            {{ $service->name }}

            <p></p>
            <p></p>
        </h2>

        <hr>

    </div>

    <h2 class="text-white text-center">Current Status</h2>

    @include('pages.services._record', ['record' => $current])

    <div class="row">
        <p></p>
    </div>

    <h2 class="text-white text-center">Service History</h2>

    @each('pages.services._record', $service->records, 'record', 'pages.services._no-records')

@endsection
