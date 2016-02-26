@extends('admin.layouts.master')

@section('title.header')

    <h3 class="text-center">@section('title') Setup Complete @show</h3>

    <hr>
@endsection

@section('content')

    <div class="col-md-12 text-center">

        <i class="fa fa-check-circle-o fa-5x"></i>

        <br>

        <p class="h4">
            You've successfully created an administrator. You can now login.
        </p>

    </div>

@endsection
