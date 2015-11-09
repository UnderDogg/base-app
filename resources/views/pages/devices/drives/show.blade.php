@extends('layouts.master')

@section('title', $drive->name)

@section('title.header')
    <h3>@yield('title') <span class="text-muted">created {{ $drive->createdAtHuman() }}</span></h3>

    <hr>
@stop

@section('content')

    <div class="col-md-3">
        <h5>Current Directory Permissions</h5>

        @include('pages.devices.drives._show-nav')
    </div>

    <div class="col-md-9">

        <div class="panel panel-default">

            <div class="panel panel-heading">
                <div class="panel-title">Items</div>
            </div>

            <div class="panel panel-body">
                {!! $items !!}
            </div>

        </div>

    </div>

@stop
