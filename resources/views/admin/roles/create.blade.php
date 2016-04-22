@extends('admin.layouts.panel')

@section('title', 'Create Role')

@section('title.header', ' ')

@section('panel.title')

    Create a Role

    <div class="pull-right text-muted">

        <i class="fa fa-user-md"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
