@extends('admin.layouts.panel')

@section('title', 'Create Permission')

@section('title.header', ' ')

@section('panel.title')

    Create a Permission

    <div class="pull-right text-muted">

        <i class="fa fa-check-circle-o"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
