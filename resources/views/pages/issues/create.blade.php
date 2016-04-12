@extends('layouts.master')

@section('title', 'Create a Ticket')

@section('title.header', ' ')

@section('content')

    <div class="panel panel-default">

        <div class="panel panel-heading">

            <div class="panel-title">

                Create a Ticket

                <div class="pull-right text-muted">

                    <i class="fa fa-ticket"></i>

                </div>

            </div>

        </div>

        <div class="panel-body">

            <div class="col-md-12">

                {!! $form !!}

            </div>

        </div>

    </div>

@endsection
