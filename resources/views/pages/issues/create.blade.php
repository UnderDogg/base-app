@extends('layouts.panel')

@section('title', 'Create a Ticket')

@section('title.header', ' ')

@if ($first)

    @section('extra.top')

        <div class="alert alert-info text-center">

            <p><b>Hey There!</b></p>

            <p>
                 It looks like this is your first ticket.
            </p>

            <p>
                Just wanted to let you know, that tickets you create are completely private, <b>between you and helpdesk administrators.</b>
            </p>

        </div>

    @endsection

@endif

@section('panel.title')

    Create a Ticket

    <div class="pull-right text-muted">

        <i class="fa fa-ticket"></i>

    </div>

@endsection

@section('panel.body')

    {!! $form !!}

@endsection
