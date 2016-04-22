@extends('admin.layouts.panel')

@section('title', 'Create User')

@section('title.header', ' ')

@section('panel.title')

    Create a User

    <div class="pull-right text-muted">

        <i class="fa fa-user"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
