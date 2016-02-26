@extends('admin.layouts.master')

@section('title.header')

    <h3>
        @section('title') All Permissions @show

        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus-circle"></i>
            Create
        </a>
    </h3>

    <div class="clearfix"></div>

    <hr>

@endsection

@section('content')

    {!! $permissions !!}

@endsection
