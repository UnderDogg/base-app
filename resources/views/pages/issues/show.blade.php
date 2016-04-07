@extends('layouts.master')

@section('title', $issue->title)

@section('title.header')

    <a class="btn btn-primary" href="{{ route('issues.index') }}">
        <i class="fa fa-caret-left"></i>
        Back to Tickets
    </a>

    <hr>

@endsection

@section('content')

    <!-- Issue -->
    @include('pages.issues._issue', compact('resolution'))

    <!-- Issue Tags -->
    @include('pages.issues._tags')

    <!-- Comments -->
    @foreach($issue->comments as $comment)
        @include('pages.issues._comment', compact($issue, $comment))
    @endforeach

    @if($issue->closed)

        <!-- Closed -->
        <div class="panel panel-danger">

            <div class="panel-heading text-center">
                Closed
            </div>

        </div>

    @endif

    <!-- Comment Form -->

    <div class="panel panel-default">

        <div class="panel-heading">

            <div class="panel-title">
                Leave a Reply

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

                {!! $formComment !!}

            </div>

        </div>

    </div>

    <div class="col-md-12">

        <hr>

    </div>

    <!-- Close / Re-Open Ticket -->
    <div class="col-md-12 text-center">

        @if($issue->isOpen())

            @if(\App\Policies\IssuePolicy::close(auth()->user(), $issue))

                <a
                        data-post="POST"
                        data-title="Close Ticket?"
                        data-message="Are you sure you want to close this ticket?"
                        class="btn btn-danger"
                        href="{{ route('issues.close', [$issue->id]) }}"
                >
                    <i class="fa fa-times"></i>
                    Close
                </a>

            @endif

        @else

            @if(\App\Policies\IssuePolicy::open(auth()->user(), $issue))

                <a
                        data-post="POST"
                        data-title="Re-Open Ticket?"
                        data-message="Are you sure you want to re-open this ticket?"
                        class="btn btn-success"
                        href="{{ route('issues.open', [$issue->id]) }}"
                >
                    <i class="fa fa-check"></i>
                    Re-Open Ticket
                </a>

            @endif

        @endif

    </div>

@endsection
