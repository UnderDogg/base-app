@extends('layouts.master')

@section('title', $issue->title)

@section('content')

    <div class="row">

        <div class="col-md-12">

            {!! $issue->statusLabel() !!}

            <span class="text-muted hidden-xs">{!! $issue->tagLine() !!}</span>

        </div>

        <div class="col-md-12 visible-xs">
            <br>
            <span class="text-muted">{!! $issue->tagLine() !!}</span>
        </div>

    </div>

    <br>

    <div class="row">

        <div class="col-md-12">
            @foreach($issue->labels as $label)
                {!! $label->displayLarge() !!}
            @endforeach
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
                    'class' => 'form-confirm',
                    'data-title' => 'Close Issue?',
                    'data-message' => 'Are you sure you want to close this issue?',
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
                    'class' => 'form-confirm',
                    'data-title' => 'Re-Open Issue?',
                    'data-message' => 'Are you sure you want to re-open this issue?',
                ])
            !!}

            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> Re-Open Issue
            </button>

            {!! Form::close() !!}

        @endif

    </div>

@stop
