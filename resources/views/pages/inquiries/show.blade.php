@extends('layouts.master')

@section('title', $inquiry->title)

@section('title.header')

    <a class="btn btn-primary" href="{{ route('inquiries.index')  }}">
        <i class="fa fa-caret-left"></i>
        Back to Requests
    </a>

    <hr>

@endsection

@section('content')

    <!-- Spacing -->
    <p></p>

    <!-- Category -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            {!! $inquiry->category_tag !!}
        </div>
    </div>

    <!-- Request -->
    @include('pages.inquiries._inquiry', compact('inquiry'))

    <!-- Comments -->
    @foreach($inquiry->comments as $comment)
        @include('pages.inquiries._comment', compact('inquiry', 'comment'))
    @endforeach

    <!-- Approved -->
    @if($inquiry->approved)

        <div class="panel panel-success">
            <div class="panel-heading text-center">
                <i class="fa fa-check-circle"></i>
                Approved
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

                @if(\App\Policies\InquiryPolicy::approve(auth()->user()))

                    <a
                            data-post="POST"
                            data-title="Approve Request?"
                            data-message="Are you sure you want to complete this request? It cannot be un-approved."
                            class="btn btn-success"
                            href="{{ route('inquiries.approve', [$inquiry->id]) }}"
                    >
                        <i class="fa fa-check"></i>
                        Approve
                    </a>

                @endif

            @endif

            @if($inquiry->isOpen())

                @if(\App\Policies\InquiryPolicy::close(auth()->user(), $inquiry))

                    <a
                            data-post="POST"
                            data-title="Close Request?"
                            data-message="Are you sure you want to close this request?"
                            class="btn btn-danger"
                            href="{{ route('inquiries.close', [$inquiry->id]) }}"
                    >
                        <i class="fa fa-times"></i>
                        Close
                    </a>
                    
                @endif

            @else

                @if(\App\Policies\InquiryPolicy::open(auth()->user()))

                    <a
                            data-post="POST"
                            data-title="Re-Open Request?"
                            data-message="Are you sure you want to re-open this request?"
                            class="btn btn-danger"
                            href="{{ route('inquiries.open', [$inquiry->id]) }}"
                    >
                        <i class="fa fa-check"></i>
                        Re-Open
                    </a>

                @endif

            @endif

        </div>

    </div>

    <div class="col-md-4"></div>

@endsection
