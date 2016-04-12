@extends('components.comment')

@section('comment.body')

    <p>{!! $comment->content_from_markdown !!}</p>

@overwrite

@section('comment.actions')

    @if(\App\Policies\InquiryCommentPolicy::edit(auth()->user(), $inquiry, $comment))
        <a
                class="btn btn-default btn-sm"
                href="{{ route('inquiries.comments.edit', [$inquiry->id, $comment->id]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
    @endif

    @if(\App\Policies\InquiryCommentPolicy::destroy(auth()->user(), $inquiry, $comment))
        <a
                class="btn btn-default btn-sm"
                data-post="DELETE"
                data-title="Delete Comment?"
                data-message="Are you sure you want to delete this comment?"
                href="{{ route('inquiries.comments.destroy', [$inquiry->id, $comment->id]) }}">
            <i class="fa fa-times"></i>
            Delete
        </a>
    @endif

@overwrite
