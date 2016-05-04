@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">

            <div class="panel-title">

                @yield('panel.title')

            </div>

        </div>

        <div class="panel-body">

            <div class="col-md-12">

                @yield('panel.body')

            </div>

        </div>

    </div>

@endsection
