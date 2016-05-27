@extends('layouts.app')

@section('title', $issue->title)

@section('title.header')

    <a class="btn btn-primary hidden-print" href="{{ route('issues.index') }}">

        <i class="fa fa-caret-left"></i>

        Back to Tickets

    </a>

    <hr>

@endsection

@section('content')

    <!-- Issue. -->
    @include('pages.issues._issue')

    <!-- Issue Tags. -->
    @include('pages.issues._tags')

    <!-- Comments. -->
    @foreach($issue->comments as $comment)
        @include('pages.issues._comment')
    @endforeach

    @if($issue->closed)

        <!-- Closed. -->
        @include('pages.issues._closed')

    @endif

    <!-- Comment Form. -->
    <div class="panel panel-default hidden-print">

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

    <div class="col-md-12 hidden-print">

        <hr>

    </div>

    <!-- Close / Re-Open Ticket. -->
    <div class="col-md-12 text-center hidden-print">

        @if($issue->isOpen())

            @can('issues.close', [$issue])

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

            @endcan

        @else

            @can('issues.open', [$issue])

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

            @endcan

        @endif

    </div>

@endsection
