@extends('layouts.jumbotron')

@section('title', 'Welcome')

@section('content')

    <div class="text-center text-white">

        <h1 class="hidden-xs">Welcome.</h1>

        <h2 class="visible-xs">Welcome.</h2>

    </div>

    <div class="row" id="panels">

        @if(auth()->check())

            <div class="col-md-6">

                <div class="panel panel-default">

                    <div class="panel-heading text-center">
                        <div class="panel-title">
                            <i class="fa fa-ticket"></i>
                            Your Last Ticket
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="col-md-12">

                            <div class="clearfix"></div>

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

            </div>

        @endif

        <div class="col-md-6">

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

        </div>

        <div class="col-md-6">

            <div class="panel panel-default">

                <div class="panel-heading text-center">

                    <div class="panel-title">
                        <i class="fa fa-info-circle"></i>
                        Most Recently Created Guides
                    </div>

                </div>

                <div class="panel-body">
                    {!! $guides !!}
                </div>

            </div>

        </div>

        @if(isset($forecast) && $forecast instanceof \Illuminate\Support\Fluent)

            <div class="col-md-6">

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

            </div>

        @endif

        @if(isset($news) && $news instanceof \Illuminate\Support\Fluent)

            <div class="col-md-6">

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

            </div>

        @endif

    </div>

@endsection
