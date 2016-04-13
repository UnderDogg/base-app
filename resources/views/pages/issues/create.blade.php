@extends('layouts.panel')

@section('title', 'Create a Ticket')

@section('title.header', ' ')

@if ($first)

    @section('extra.top')

        <div class="alert alert-info text-center">

            <p>
                <b>Hey There.</b> It looks like this is your first ticket.
            </p>

            <p>
                We just wanted to let you know, that ticket you create are completely private, meaning only you and helpdesk administrators will be able to view it.
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
