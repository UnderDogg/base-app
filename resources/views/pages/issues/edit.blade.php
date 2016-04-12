@extends('layouts.panel')

@section('title', 'Edit Ticket')

@section('title.header', ' ')

@section('panel.title')

    Edit Your Ticket

    <div class="pull-right text-muted">

        <i class="fa fa-ticket"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
