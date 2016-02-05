@extends('layouts.master')

@section('title', "$service->name Status")

@section('container')

    <style>
        .jumbotron-welcome {
            position: relative;
            background: #000 url('{{ asset('jumbotron-bg.png') }}') center center;
            width: 100%;
            height: 100%;
            min-height: 100vh;
            background-size: cover;
            overflow: hidden;
            margin-bottom: 0;
        }

        .jumbotron-welcome p {
            font-size: 15px;
        }

        .jumbotron-welcome .container h1 {
            font-size: 60px;
            padding: 0 150px;
            margin-top: -10px;
            margin-bottom: 80px;
        }

        .navbar {
            margin-bottom: 0;
        }
    </style>

    <div class="jumbotron jumbotron-welcome">

        <div class="container">

            <div class="text-center text-white">

                <h1 class="hidden-xs">
                    <i class="fa fa-server"></i>
                    {{ $service->name }}
                </h1>

                <h2 class="visible-xs">
                    <i class="fa fa-server"></i>
                    {{ $service->name }}

                    <p></p>
                    <p></p>
                </h2>

                <hr>

            </div>

            <h2 class="text-white text-center">Current Status</h2>

            @include('pages.services._record', ['record' => $current])

            <div class="row">
                <p></p>
            </div>

            <h2 class="text-white text-center">Service History</h2>

            @each('pages.services._record', $service->records, 'record', 'pages.services._no-records')

        </div>

    </div>

@endsection

@section('footer', ' ')
