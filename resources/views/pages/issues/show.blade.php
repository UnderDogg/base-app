@extends('layouts.master')

@section('title', $issue->title)

@section('title.header')
    <h3>
        {{ $issue->title }}

        <span class="text-muted">{{ $issue->getHashId() }}</span>
    </h3>
@stop

@section('content')

    <div class="row">

        <div class="col-md-12">

            {!! $issue->getStatusLabel() !!}

            <span class="text-muted hidden-xs">{!! $issue->getTagLine() !!}</span>

        </div>

        <div class="col-md-12 visible-xs">
            <br>
            <span class="text-muted">{!! $issue->getTagLine() !!}</span>
        </div>

    </div>

    <br>

    <div class="row">

        <div class="col-md-12">
            @foreach($issue->labels as $label)
                {!! $label->getDisplayLarge() !!}
            @endforeach

            @can('addLabels', $issue)
                <span class="pull-right">
                    <a class="btn btn-default" href="#" data-toggle="modal" data-target="#label-modal">
                        <i class="fa fa-tag"></i>
                        Labels
                    </a>
                </span>

                <div class="modal fade" id="label-modal" tabindex="-1" role="dialog" aria-labelledby="label-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            {!! $formLabels !!}
                        </div>
                    </div>
                </div>
            @endcan
        </div>

    </div>

    <br>

    <div class="clearfix"></div>

    @include('pages.issues._issue')

    @each('pages.issues._comment',  $issue->comments, 'comment')

    <div class="col-md-12">
        {!! $formComment !!}
    </div>

    <div class="col-md-12">
        <hr>
    </div>

    <div class="col-md-12 text-center">

        @if($issue->isOpen())

            @can('close', $issue)

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

            @endcan

        @else

            @can('open', $issue)

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

            @endcan

        @endif

    </div>

@stop
