<div class="card" id="comment-{{ $comment->id }}">

    <div class="card-title col-md-12">

        <h4>

            <span class="pull-right text-muted">
                <i class="fa fa-comment"></i>
            </span>

        </h4>

        <div class="clearfix"></div>

    </div>

    <div class="card-heading image">

        <img class="avatar" src="{{ route('profile.avatar.download', [$comment->user->id]) }}" alt=""/>

        <div class="card-heading-header">

            <h3>{{ $comment->user->name }}</h3>

            <span>{!! $comment->created_at_human !!}</span>

        </div>

    </div>

    <div class="card-body">

        <div class="card-body-reply">

            <p>
                {!! $comment->content_from_markdown !!}
            </p>

        </div>

    </div>

    <div class="card-actions pull-right">
        @if(\App\Policies\InquiryCommentPolicy::edit(auth()->user(), $inquiry, $comment))
            <a
                    class="btn btn-default btn-sm edit-comment-button"
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
    </div>

    <div class="clearfix"></div>

</div>
