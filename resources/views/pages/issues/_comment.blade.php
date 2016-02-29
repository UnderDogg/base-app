<div class="card @if($comment->resolution) answer @endif">

    @if($comment->resolution)
        <div class="col-md-12 answer-heading">

            <h4>
                <i class="fa fa-check-square"></i>
                Answer
            </h4>

        </div>
    @endif

    <div class="card-heading image">

        <img src="{{ route('profile.avatar.download', [$comment->user->getKey()]) }}" alt=""/>

        <div class="card-heading-header">

            <h3>{{ $comment->user->fullname }}</h3>

            <span>{!! $comment->created_at_human !!}</span>

        </div>

    </div>

    <div class="card-body">
        <p>
            {!! $comment->content_from_markdown !!}
        </p>
    </div>

    <div class="card-actions pull-right">
        @if(\App\Policies\IssueCommentPolicy::edit(auth()->user(), $issue, $comment))
        <a
                class="btn btn-default btn-sm"
                href="{{ route('issues.comments.edit', [$comment->pivot->issue_id, $comment->getKey()]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
        @endif

        @if(\App\Policies\IssueCommentPolicy::destroy(auth()->user(), $issue, $comment))
            <a
                    class="btn btn-default btn-sm"
                    data-post="DELETE"
                    data-title="Delete Comment?"
                    data-message="Are you sure you want to delete this comment?"
                    href="{{ route('issues.comments.destroy', [$comment->pivot->issue_id, $comment->getKey()]) }}">
                <i class="fa fa-times"></i>
                Delete
            </a>
        @endif
    </div>

    <div class="clearfix"></div>

</div>
