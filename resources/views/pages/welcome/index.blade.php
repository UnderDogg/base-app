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

        .row {
            -moz-column-width: 35em;
            -webkit-column-width: 35em;
            -moz-column-gap: .5em;
            -webkit-column-gap: .5em;
        }

        .panel {
            display: inline-block;
            margin:  .5em;
            padding:  0;
            width:98%;
        }
    </style>

    <div class="jumbotron">

        <div class="container">

            <div class="text-center text-white">
                <h1 class="hidden-xs">Welcome.</h1>

                <h2 class="visible-xs">Welcome.</h2>
            </div>

            <div class="row">

                @if(auth()->check())
                    <div class="panel panel-default">

                            <div class="panel-heading text-center">
                                <div class="panel-title">
                                    <i class="fa fa-ticket"></i>
                                    Your Last Ticket
                                </div>
                            </div>

                            <div class="panel-body">

                                <div class="col-md-12">

                                    <div class="visible-xs">
                                        <a class="btn btn-sm btn-success pull-left" href="{{ route('issues.create') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            Create An Ticket
                                        </a>

                                        <a class="btn btn-sm btn-default pull-right" href="{{ route('issues.index') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            View My Ticket
                                        </a>
                                    </div>

                                    <div class="hidden-xs">
                                        <a class="btn btn-md btn-success pull-left" href="{{ route('issues.create') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            Create A Ticket
                                        </a>

                                        <a class="btn btn-md btn-default pull-right" href="{{ route('issues.index') }}">
                                            <i class="fa fa-exclamation-circle"></i>
                                            View Tickets
                                        </a>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <p><br></p>
                                </div>

                                <div class="col-md-12">
                                    {!! $issues !!}
                                </div>

                            </div>

                        </div>
                @endif

                <div class="panel panel-default">

                    <div class="panel-heading text-center">
                        <div class="panel-title">
                            <i class="fa fa-server"></i>
                            Service Status
                        </div>
                    </div>

                    <div class="panel-body">
                        {!! $services !!}
                    </div>

                </div>

                @if(isset($forecast) && $forecast instanceof \Illuminate\Support\Fluent)

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <div class="text-center panel-title">
                                <i class="fa fa-sun-o"></i>
                                {{ $forecast->title }}
                            </div>

                        </div>

                        <div class="text-center panel-body">
                            @each('pages.welcome._entry', $forecast->articles, 'entry', 'pages.welcome._no_forecast')
                        </div>

                    </div>

                @endif

                @if(isset($news) && $news instanceof \Illuminate\Support\Fluent)

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <div class="text-center panel-title">
                                <i class="fa fa-bookmark"></i>
                                {{ $news->title }}
                            </div>

                        </div>

                        <div class="panel-body">
                            @each('pages.welcome._article', $news->articles, 'article', 'pages.welcome._no_articles')
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection

@section('footer')
@endsection
