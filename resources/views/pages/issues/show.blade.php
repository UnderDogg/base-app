@extends('layouts.master')

@section('title', $issue->title)

@section('content')

    <div class="row">

        <div class="col-md-12">

            {!! $issue->statusLabel() !!} <span class="text-muted">{!! $issue->tagLine() !!}</span>

        </div>

    </div>

    <br>

    <div class="clearfix"></div>

    @include('pages.issues._issue')

    @each('pages.issues._comment',  $issue->comments, 'comment')

    <div class="col-md-12">
        {!! $form !!}
    </div>

    <div class="col-md-12">
        <hr>
    </div>

    <div class="col-md-12 text-center">
        @if($issue->isOpen())

            {!!
                Form::open([
                    'url' => route('issues.close', [$issue->getKey()]),
                ])
            !!}

            <button type="submit" class="btn btn-danger">
                <i class="fa fa-times"></i> Close Issue
            </button>

            {!! Form::close() !!}

        @else

            {!!
                Form::open([
                    'url' => route('issues.open', [$issue->getKey()]),
                ])
            !!}

            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> Re-Open Issue
            </button>

            {!! Form::close() !!}

        @endif
    </div>

@stop
