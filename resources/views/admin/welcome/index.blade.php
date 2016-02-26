@extends('admin.layouts.jumbotron')

@section('title', 'Welcome')

@section('content')

    <div class="text-white text-center">

        <h1 class="hidden-xs">Welcome.</h1>

        <h3 class="visible-xs">Welcome.</h3>

        <hr>

    </div>

    <div class="col-md-4">

        <div class="panel panel-info">

            <div class="panel-body">

                <i class="fa fa-5x fa-users pull-left"></i>

                <div class="pull-left">
                    <h3>
                        Users:

                        <span class="h2">
                            {{ $users }}
                        </span>
                    </h3>

                    <a class="btn btn-xs btn-default" href="{{ route('admin.users.index') }}">View All</a>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="panel panel-info">

            <div class="panel-body">

                <i class="fa fa-5x fa-user-md pull-left"></i>

                <div class="pull-left">
                    <h3>
                        Roles:

                        <span class="h2">
                            {{ $roles }}
                        </span>
                    </h3>

                    <a class="btn btn-xs btn-default" href="{{ route('admin.roles.index') }}">View All</a>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="panel panel-info">

            <div class="panel-body">

                <i class="fa fa-5x fa-check-circle-o pull-left"></i>

                <div class="pull-left">
                    <h3>
                        Permissions:

                        <span class="h2">
                            {{ $permissions }}
                        </span>
                    </h3>

                    <a class="btn btn-xs btn-default" href="{{ route('admin.permissions.index') }}">View All</a>
                </div>

            </div>

        </div>

    </div>

@endsection
