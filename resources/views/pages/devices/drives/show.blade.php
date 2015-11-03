@extends('layouts.master')

@section('title', $drive->name)

@section('title.header')
    <h3>@yield('title') <span class="text-muted">created {{ $drive->createdAtHuman() }}</span></h3>

    <hr>
@stop

@section('content')

    <div class="col-md-12">

        <div class="panel panel-default">



        </div>

    </div>

@stop
