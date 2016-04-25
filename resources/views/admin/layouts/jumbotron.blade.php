@extends('admin.layouts.app')

@section('container')

    <style>
        .jumbotron-welcome {
            position: relative;
            background: #39475A url('{{ asset('img/geometry.png') }}') center center;
            width: 100%;
            height: 100%;
            min-height: 100vh;
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

            @yield('content')

        </div>

    </div>

@endsection

@section('footer', ' ')
