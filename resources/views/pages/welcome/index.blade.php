@extends('layouts.jumbotron')

@section('title', 'Welcome')

@section('content')

    <div class="row" id="panels">

        <div class="col-md-12">

            <div class="col-md-6">

                @if(auth()->check())

                    <!-- Last Ticket Panel -->
                    <div class="panel panel-default">

                        <div class="panel-heading text-center">

                            <div class="panel-title">
                                <i class="fa fa-ticket"></i>
                                Your Last Ticket
                            </div>

                        </div>

                        <div class="panel-body">

                            <div class="col-md-12">
                                {!! $issues !!}
                            </div>

                        </div>

                    </div>

                @endif

                <!-- Services Panel -->
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

                <!-- Guides Panel -->
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

            <div class="col-md-6">

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
