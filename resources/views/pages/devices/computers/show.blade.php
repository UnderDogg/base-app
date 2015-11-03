@extends('layouts.master')

@section('title', $computer->name)

@section('title.header')
    <h3>@yield('title') <span class="text-muted">created {{ $computer->createdAtHuman() }}</span></h3>

    <hr>
@stop

@section('content')

    <div class="col-md-3">
        @include('pages.devices.computers._show-nav')
    </div>

    <div class="col-md-9">

        <div class="panel panel-default">

            <div class="panel-heading">

                <div class="panel-title">
                    @yield('show.panel.title')
                </div>

            </div>

            <div class="panel-body">

                @yield('show.panel.body')

            </div>

            <div class="panel-footer">

                @yield('show.panel.footer')

            </div>

        </div>

    </div>

@stop
