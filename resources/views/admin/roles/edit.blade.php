@extends('admin.layouts.panel')

@section('title', 'Edit Role')

@section('title.header', ' ')

@section('panel.title')

    Edit Role

    <div class="pull-right text-muted">

        <i class="fa fa-user-md"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
