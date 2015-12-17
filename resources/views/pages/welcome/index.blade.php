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
            </div>

            @if(auth()->check())
                <div class="col-md-12">

                    <div class="panel panel-default">

                        <div class="panel-heading text-center">
                            <div class="panel-title">
                                Issues
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="visible-xs">
                                        <a class="btn btn-sm btn-success pull-left" href="{{ route('issues.create') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            Create An Issue
                                        </a>

                                        <a class="btn btn-sm btn-default pull-right" href="{{ route('issues.index') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            View My Issues
                                        </a>
                                    </div>

                                    <div class="hidden-xs">
                                        <a class="btn btn-md btn-success pull-left" href="{{ route('issues.create') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            Create An Issue
                                        </a>

                                        <a class="btn btn-md btn-default pull-right" href="{{ route('issues.index') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            View My Issues
                                        </a>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    {!! $issues !!}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            @endif

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
                        @each('pages.welcome._article', $news->articles, 'article', 'pages.welcome._no_articles')
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('footer')
@endsection
