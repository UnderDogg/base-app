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

    <!-- Attachments -->
    @include('pages.issues._files')

    <!-- Issue Tags -->
    @include('pages.issues._tags')

    <!-- Comments -->
    @foreach($issue->comments as $comment)
        @include('pages.issues._comment', compact($issue, $comment))
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

            @if(\App\Policies\IssuePolicy::close(auth()->user(), $issue))

                <a
                        data-post="POST"
                        data-title="Close Ticket?"
                        data-message="Are you sure you want to close this ticket?"
                        class="btn btn-danger"
                        href="{{ route('issues.close', [$issue->getKey()]) }}"
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
                        href="{{ route('issues.open', [$issue->getKey()]) }}"
                >
                    <i class="fa fa-check"></i>
                    Re-Open Ticket
                </a>

            @endif

        @endif

    </div>

@endsection
