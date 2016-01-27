@extends('layouts.master')

@section('extra.top')
    <a class="btn btn-primary" href="{{ route('issues.index') }}">
        <i class="fa fa-chevron-left"></i>
        Back to Tickets
    </a>
@endsection

@section('title', $issue->title)

@section('title.header')
    <h3>
        {{ $issue->title }}

        <span class="text-muted">{{ $issue->getHashId() }}</span>
    </h3>

    {!! $issue->getStatusLabel() !!}
@endsection

@section('content')

    <div class="row">

        <!-- Labels -->
        <div class="labels col-md-12">
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

    <!-- Issue -->
    @include('pages.issues._issue', compact('resolution'))

    <!-- Comments -->
    @include('pages.issues._comments')

    @if($issue->isClosed())

        <!-- Closed -->
        @include('pages.issues._closed', compact('issue'))

    @endif

    <!-- Comment Form -->
    <div class="col-md-12">
        {!! $formComment !!}
    </div>

    <div class="col-md-12">

        <hr>

    </div>

    <!-- Close / Re-Open Ticket -->
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
                <i class="fa fa-times"></i> Close Ticket
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
                <i class="fa fa-check"></i> Re-Open Ticket
            </button>

            {!! Form::close() !!}

            @endcan

        @endif

    </div>

@endsection
