<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">
            {{ $comment->user->fullname }}

            <span class="hidden-xs">
                {!! $comment->tagLine() !!}
            </span>

            <span class="pull-right">
                @can('update', $comment)
                    <a href="{{ route('issues.comments.edit', [$comment->pivot->issue_id, $comment->id]) }}"><i class="fa fa-edit"></i></a>
                @endcan

                @can('destroy', $comment)
                    <a
                            data-post="DELETE"
                            data-title="Delete Comment?"
                            data-message="Are you sure you want to delete this comment?"
                            href="{{ route('issues.comments.destroy', [$comment->pivot->issue_id, $comment->id]) }}">
                        <i class="fa fa-times"></i>
                    </a>
                @endcan
            </span>

            <div class="clearfix"></div>

            <div class="visible-xs">
                {!! $comment->tagLine() !!}
            </div>
        </h3>

    </div>

    <div class="panel-body">
        {!! $comment->contentFromMarkdown() !!}
    </div>

</div>
