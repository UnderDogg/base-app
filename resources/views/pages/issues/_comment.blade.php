<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">
            {{ $comment->user->fullname }}

            <span class="text-muted hidden-xs">
                commented {{ $comment->createdAtDaysAgo() }}
            </span>

            @can('update', $comment)
                <span class="pull-right">
                    <a href="{{ route('issues.comments.edit', [$comment->pivot->issue_id, $comment->id]) }}"><i class="fa fa-edit"></i></a>
                </span>
            @endcan

            <div class="clearfix"></div>

            <div class="visible-xs">
                <span class="text-muted">
                    commented {{ $comment->createdAtDaysAgo() }}
                </span>
            </div>
        </h3>

    </div>

    <div class="panel-body">
        {!! $comment->content !!}
    </div>

</div>
