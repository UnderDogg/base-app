@extends('layouts.master')

@section('extra.top')
    <a class="btn btn-primary" href="{{ route('inquiries.index')  }}">
        <i class="fa fa-chevron-left"></i>
        Back to Requests
    </a>
@endsection

@section('title', $inquiry->title)

@section('title.header', ' ')

@section('content')

    <!-- Request -->
    @include('pages.inquiries._inquiry', compact('inquiry'))

    <!-- Comments -->
    @foreach($inquiry->comments as $comment)
        @decorator('comment', $comment, [
            'edit'      => route('inquiries.comments.edit', [$comment->pivot->inquiry_id, $comment->getKey()]),
            'destroy'   => route('inquiries.comments.destroy', [$comment->pivot->inquiry_id, $comment->getKey()]),
        ])
    @endforeach

    <!-- Approved -->
    @if($inquiry->approved)

        <div class="panel panel-success">
            <div class="panel-heading text-center">
                <i class="fa fa-check-circle"></i>
                Complete
                @if($inquiry->closed)
                    & Closed
                @endif
            </div>
        </div>

    @endif

    <!-- Closed -->
    @if($inquiry->closed && ! $inquiry->approved)

        <div class="panel panel-danger">
            <div class="panel-heading text-center">
                Closed
            </div>
        </div>

    @endif

    <!-- Comment Form -->
    <div class="col-md-12">

        {!! $formComment !!}

        <hr>

    </div>

    <div class="col-md-4"></div>

    <!-- Close / Re-Open / Approve Inquiry -->
    <div class="col-md-12 text-center">

        <div class="btn-group" role="group">

            @if(!$inquiry->approved)

                @can('approve', $inquiry)

                    <a
                            data-post="POST"
                            data-title="Approve Request?"
                            data-message="Are you sure you want to complete this request? It cannot be un-approved."
                            class="btn btn-success"
                            href="{{ route('inquiries.approve', [$inquiry->getKey()]) }}"
                    >
                        <i class="fa fa-check"></i>
                        Complete
                    </a>

                @endcan

            @endif

            @if($inquiry->isOpen())

                @can('close', $inquiry)

                    <a
                            data-post="POST"
                            data-title="Close Request?"
                            data-message="Are you sure you want to close this request?"
                            class="btn btn-danger"
                            href="{{ route('inquiries.close', [$inquiry->getKey()]) }}"
                    >
                        <i class="fa fa-times"></i>
                        Close
                    </a>

                @endcan

            @else

                @can('open', $inquiry)

                    <a
                            data-post="POST"
                            data-title="Re-Open Request?"
                            data-message="Are you sure you want to re-open this request?"
                            class="btn btn-danger"
                            href="{{ route('inquiries.open', [$inquiry->getKey()]) }}"
                    >
                        <i class="fa fa-check"></i>
                        Re-Open
                    </a>

                @endcan

            @endif

        </div>

    </div>

    <div class="col-md-4"></div>

@endsection
