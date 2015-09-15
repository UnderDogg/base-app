<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">
            {{ $comment->user->fullname }}
            <span class="text-muted pull-right">
                {{ $comment->createdAtDaysAgo() }}
            </span>
            <div class="clearfix"></div>
        </h3>

    </div>

    <div class="panel-body">
        {!! $comment->content !!}
    </div>

</div>
