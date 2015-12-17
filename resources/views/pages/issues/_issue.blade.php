<div class="panel panel-info">

    <div class="panel-heading">

        <h3 class="panel-title">

            {{ $issue->user->fullname }}

            <span class="text-muted hidden-xs">
                {{ $issue->getCreatedAtTagLine() }}
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
                    {{ $issue->getCreatedAtTagLine() }}
                </span>
            </div>

        </h3>

    </div>

    <div class="panel-body">

        {!! $issue->getDescriptionFromMarkdown() !!}

        {{--
         We'll make sure a resolution exists and that we have more than
         one comment before display the resolution here.
         --}}
        @if(isset($resolution) && count($issue->comments) > 1)
            {{-- We'll also make sure that the first comment is not a resolution. --}}
            @if(!$issue->comments->first()->isResolution())
                <hr>
                @include('pages.issues._comment', ['comment' => $resolution])
            @endif
        @endif

    </div>

    @if($issue->occurred_at)
        <div class="panel-footer text-muted">
            {{ $issue->getOccurredAtTagLine() }}
        </div>
    @endif

</div>
