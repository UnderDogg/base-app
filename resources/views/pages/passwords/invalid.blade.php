@extends('layouts.master')

@section('title', 'Whoops')

@section('title.header')
    <h3 class="text-center">
        @yield('title')
    </h3>
@stop

@section('content')

    <div class="text-center">

        <div class="col-md-12">
            <i class="fa fa-6 fa-times-circle"></i>
        </div>

        <div class="panel panel-danger col-md-12">
            <div class="panel-body">
                You've already setup passwords.
            </div>
        </div>

        <a class="btn btn-lg btn-primary" href="{{ route('passwords.index') }}">Click here to view them.</a>
    </div>

@stop
