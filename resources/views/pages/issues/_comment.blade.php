@if($comment->pivot->resolution)
    <div class="panel panel-success">
@else
    <div class="panel panel-default">
@endif


    <div class="panel-heading">

        <h3 class="panel-title">
            {{ $comment->user->fullname }}

            <span class="hidden-xs">
                {!! $comment->getTagLine() !!}
            </span>

            <span class="pull-right btn-group">
                @can('update', $comment)
                    <a
                            class="btn btn-warning btn-xs"
                            href="{{ route('issues.comments.edit', [$comment->pivot->issue_id, $comment->id]) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan

                @can('destroy', $comment)
                    <a
                            class="btn btn-danger btn-xs"
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
                {!! $comment->getTagLine() !!}
            </div>
        </h3>

    </div>

    <div class="panel-body">
        {!! $comment->contentFromMarkdown() !!}
    </div>

</div>
