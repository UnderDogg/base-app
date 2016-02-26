@extends('admin.layouts.master')

@section('title.header')

    <h3>
        @section('title') All Users @show

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus-circle"></i>
            Create
        </a>
    </h3>

    <div class="clearfix"></div>

    <hr>

@endsection

@section('content')

    {!! $users !!}

@endsection
