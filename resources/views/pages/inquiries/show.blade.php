@extends('layouts.master')

@section('extra.top')
    <a class="btn btn-primary" href="{{ route('issues.index') }}">
        <i class="fa fa-chevron-left"></i>
        Back to Tickets
    </a>
@endsection

@section('title', $inquiry->title)

@section('title.header', ' ')

@section('content')

    <!-- Request -->
    @include('pages.inquiries._inquiry', compact('inquiry'))

    <!-- Comments -->
    @foreach($inquiry->comments as $comment)
        @decorator('comment', [
            'comment'   => $comment,
            'actions'   => [
                'edit'      => route('inquiries.comments.edit', [$comment->pivot->inquiry_id, $comment->getKey()]),
                'destroy'   => route('inquiries.comments.destroy', [$comment->pivot->inquiry_id, $comment->getKey()]),
            ],
        ])
    @endforeach

    @if($inquiry->closed)

        <!-- Closed -->
        @include('pages.issues._closed', compact('issue'))

    @endif

@endsection
