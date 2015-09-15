<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">
            {{ $issue->user->fullname }}

            <span class="text-muted hidden-xs">
                commented {{ $issue->createdAtDaysAgo() }}
            </span>

            @can('update', $issue)
                <span class="pull-right">
                    <a href="{{ route('issues.edit', [$issue->id]) }}"><i class="fa fa-edit"></i></a>
                </span>
            @endcan

            <div class="clearfix"></div>

            <div class="visible-xs">
                <span class="text-muted">
                    commented {{ $issue->createdAtDaysAgo() }}
                </span>
            </div>
        </h3>

    </div>

    <div class="panel-body">
        {!! $issue->description !!}
    </div>

</div>
