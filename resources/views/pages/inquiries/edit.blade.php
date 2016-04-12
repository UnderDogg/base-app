@extends('layouts.master')

@section('title', 'Edit Request')

@section('title.header', ' ')

@section('content')

    <div class="panel panel-default">

        <div class="panel panel-heading">

            <div class="panel-title">

                Edit Your Request

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
