@extends('layouts.master')

@section('extra.top')
    <a class="btn btn-primary" href="{{ route('issues.index') }}">
        <i class="fa fa-chevron-left"></i>
        Back to Tickets
    </a>
@endsection

@section('title', $issue->title)

@section('title.header', ' ')

@section('content')

    <!-- Issue -->
    @include('pages.issues._issue', compact('resolution'))

    <!-- Comments -->
    @foreach($issue->comments as $comment)
        @decorator('comment', [
            'comment'   => $comment,
            'actions'   => [
                'edit'      => route('issues.comments.edit', [$comment->pivot->issue_id, $comment->getKey()]),
                'destroy'   => route('issues.comments.destroy', [$comment->pivot->issue_id, $comment->getKey()]),
            ],
        ])
    @endforeach

    @if($issue->closed)

        <!-- Closed -->
        @decorator('closed', $issue)

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
