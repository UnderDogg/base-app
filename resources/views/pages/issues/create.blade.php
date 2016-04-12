@extends('layouts.panel')

@section('title', 'Create a Ticket')

@section('title.header', ' ')

@section('panel.title')

    Create a Ticket

    <div class="pull-right text-muted">

        <i class="fa fa-ticket"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
