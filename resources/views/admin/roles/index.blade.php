@extends('admin.layouts.app')

@section('title.header')

    <h3>
        @section('title') All Roles @show

        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus-circle"></i>
            Create
        </a>
    </h3>

    <div class="clearfix"></div>

    <hr>

@endsection

@section('content')

    <div class="panel panel-default">

        {!! $roles !!}

    </div>

@endsection
