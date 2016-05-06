@extends('components.comment')

@section('comment.body')

    <p>{!! $comment->content_from_markdown !!}</p>

    <div class="hidden-print">
        @include('pages.issues.comments._files', compact('comment'))
    </div>

@overwrite

@section('comment.actions')

    <div class="hidden-print">

        @can('comments.edit', [$comment])
            <a
                    class="btn btn-default btn-sm"
                    href="{{ route('issues.comments.edit', [$issue->id, $comment->id]) }}">
                <i class="fa fa-edit"></i>
                Edit
            </a>
        @endcan

        @can('comments.destroy', [$comment])
            <a
                    class="btn btn-default btn-sm"
                    data-post="DELETE"
                    data-title="Delete Comment?"
                    data-message="Are you sure you want to delete this comment?"
                    href="{{ route('issues.comments.destroy', [$issue->id, $comment->id]) }}">
                <i class="fa fa-times"></i>
                Delete
            </a>
        @endcan

    </div>

@overwrite
