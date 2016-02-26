@extends('admin.layouts.master')

@section('title.header')

    <h2 class="text-center">@section('title') Setup @show</h2>

    <hr>
@endsection

@section('content')

    <div class="col-md-12 text-center">

        <h3>
            Welcome to the Administration setup process.
        </h3>

        <br>

        <p>
            <a class="btn btn-primary" href="{{ route('admin.setup.begin') }}">
                <i class="fa fa-cog"></i>
                Begin Setup
            </a>
        </p>

    </div>

@endsection
