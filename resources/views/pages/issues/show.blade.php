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

            @foreach($issue->users as $user)
                {!! $user->getLabelLarge() !!}
            @endforeach

        </div>

    </div>

    <div class="row">

        <br>

    </div>

    <div class="row">

        <div class="col-md-12">

            @include('pages.issues._form-labels')

            @include('pages.issues._form-users')

        </div>

    </div>

    <br>

    <div class="clearfix"></div>

    @include('pages.issues._issue', compact('resolution'))

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
