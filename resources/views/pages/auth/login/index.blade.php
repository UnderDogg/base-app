@extends('layouts.app')

@section('title.header')

    @section('title', 'Login')

@endsection

@section('content')

    <div class="col-md-3"></div>

    <div class="col-md-6">

        <div class="panel panel-default">

            <div class="panel-body">

                <div class="col-md-12">

                <h3 class="text-center">
                    Login
                </h3>

                <p class="text-muted text-center">Using your windows credentials.</p>

                {!! $form !!}

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-3"></div>

@endsection
