@extends('layouts.app')

@section('title', 'Your Profile')

@section('title.header')

    <h3 class="text-center"> Your Profile </h3>

    <hr>

@endsection

@section('content')

    <div class="col-md-3">

        <div class="panel panel-default">

            @include('pages.profile._show-nav')

        </div>

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

@endsection
