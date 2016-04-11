@extends('layouts.jumbotron')

@section('title', 'Welcome')

@section('content')

    @if(auth()->check())

        <div class="row">

            <div class="col-md-4">

                <a href="{{ route('issues.create') }}" class="btn btn-success btn-xl btn-block">
                    <i class="fa fa-ticket"></i>
                    Create a New Ticket
                </a>

            </div>

            <div class="col-md-4">

                <a href="{{ route('inquiries.start') }}" class="btn btn-info btn-xl btn-block">
                    <i class="fa fa-question-circle"></i>
                    Create a New Request
                </a>

            </div>

            <div class="col-md-4">

                <a href="{{ route('resources.guides.index') }}" class="btn btn-default btn-xl btn-block">
                    <i class="fa fa-bookmark"></i>
                    View Guides
                </a>

            </div>

            <div class="clearfix"></div>

        </div>

        <hr>

        <div class="row" id="panels">

            <div class="col-md-8 col-md-offset-2">

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

        </div>

    @else



    @endif

@endsection
