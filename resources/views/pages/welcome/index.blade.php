@extends('layouts.master')

@section('title', 'Welcome')

@section('container')

    <style>
        .jumbotron {
            position: relative;
            background: #000 url('{{ asset('jumbotron-bg.png') }}') center center;
            width: 100%;
            height: 100%;
            min-height: 100vh;
            background-size: cover;
            overflow: hidden;
            margin-bottom: 0;
        }

        .jumbotron p {
            font-size: 15px;
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

        <div class="container">

            <div class="text-center text-white">
                <h1 class="hidden-xs">Welcome.</h1>

                <h2 class="visible-xs">Welcome.</h2>
            </div>d

            <div class="text-center">

                <div class="col-md-6">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Support
                        </div>
                        <div class="panel-body">

                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            Issues
                        </div>
                        <div class="panel-body">

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="panel panel-default">

                    <div class="panel-heading">

                        <div class="text-center panel-title">
                            {{ $forecast->title }}
                        </div>

                    </div>

                    <div class="text-center panel-body">
                        @each('pages.welcome._entry', $forecast->articles, 'entry', 'pages.welcome._no_forecast')
                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="panel panel-default">

                    <div class="panel-heading">

                        <div class="text-center panel-title">
                            {{ $news->title }}
                        </div>

                    </div>

                    <div class="panel-body">
                        @each('pages.welcome._article', $news->articles->take(5), 'article', 'pages.welcome._no_articles')
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('footer')
@endsection
