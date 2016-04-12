@extends('layouts.panel')

@section('title', 'Edit Comment')

@section('title.header', ' ')

@section('panel.title')

    Edit Your Comment

    <div class="pull-right text-muted">

        <i class="fa fa-comment"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
