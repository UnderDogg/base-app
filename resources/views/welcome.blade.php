@extends('layouts.master')

@section('title', 'Welcome')

@section('container')

    <style>
        .jumbotron {
            position: relative;
            background: #000 url('{{ asset('jumbotron-bg.png') }}') center center;
            width: 100%;
            height: 100vh;
            background-size: cover;
            overflow: hidden;
            margin-bottom: 0;
        }

        .jumbotron .container h1 {
            font-size: 60px;
            padding: 0 150px;
            margin-top: -10px;
            margin-bottom: 80px;
        }

        .navbar {
            margin-bottom: 0;
        }
    </style>

    <div class="jumbotron">

        <div class="container text-white text-center">

            <h1 class="hidden-xs">Welcome.</h1>

            <h2 class="visible-xs">Welcome.</h2>

            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Support
                    </div>
                    <div class="panel-body">

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Issues
                    </div>
                    <div class="panel-body">

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Assets
                    </div>
                    <div class="panel-body">

                    </div>
                </div>

            </div>

        </div>

    </div>
@stop

@section('footer')
@stop
