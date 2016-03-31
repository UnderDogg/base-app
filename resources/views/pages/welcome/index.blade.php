@extends('layouts.jumbotron')

@section('title', 'Welcome')

@section('content')

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

@endsection
