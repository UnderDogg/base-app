<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">
            {{ $issue->user->fullname }}

            <span class="text-muted hidden-xs">
                commented {{ $issue->createdAtDaysAgo() }}
            </span>

            <span class="pull-right btn-group">
                @can('edit', $issue)
                    <a class="btn btn-warning btn-xs" href="{{ route('issues.edit', [$issue->id]) }}"><i class="fa fa-edit"></i></a>
                @endcan

                @can('destroy', $issue)
                    <a
                            class="btn btn-danger btn-xs"
                            data-post="DELETE"
                            data-title="Delete Issue?"
                            data-message="Are you sure you want to delete this issue?"
                            href="{{ route('issues.destroy', [$issue->id]) }}">
                        <i class="fa fa-times"></i>
                    </a>
                @endcan
            </span>

            <div class="clearfix"></div>

            <div class="visible-xs">
                <span class="text-muted">
                    commented {{ $issue->createdAtDaysAgo() }}
                </span>
            </div>
        </h3>

    </div>

    <div class="panel-body">
        {!! $issue->getDescriptionFromMarkdown() !!}
    </div>

</div>
