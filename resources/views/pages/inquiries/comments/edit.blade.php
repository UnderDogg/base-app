@extends('layouts.master')

@section('title', 'Edit Comment')

@section('title.header', ' ')

@section('content')

    <!-- Comment Form. -->
    <div class="panel panel-default">

        <div class="panel-heading">

            <div class="panel-title">
                Edit Your Reply

                <div class="pull-right text-muted">

                    <i class="fa fa-commenting"></i>

                </div>

            </div>

        </div>

        <div class="panel-body">

            <div class="pull-right hidden-xs">
                <a href="http://commonmark.org/help/">Use Markdown to enhance your replies.</a>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-12">

                {!! $form !!}

            </div>

        </div>

    </div>

@endsection
