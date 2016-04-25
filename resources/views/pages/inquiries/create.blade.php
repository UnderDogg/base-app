@extends('layouts.app')

@section('title', "Create a $category->name Request")

@section('title.header', ' ')

@section('content')

    <div class="panel panel-default">

        <div class="panel panel-heading">

            <div class="panel-title">

                Create {{ $category->name  }} Request

                <div class="pull-right text-muted">

                    <i class="fa fa-question-circle"></i>

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
