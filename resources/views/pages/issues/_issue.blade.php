<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">
            {{ $issue->user->fullname }}
            <span class="text-muted pull-right">
                {{ $issue->createdAtDaysAgo() }}
            </span>
            <div class="clearfix"></div>
        </h3>

    </div>

    <div class="panel-body">
        {!! $issue->description !!}
    </div>

</div>
