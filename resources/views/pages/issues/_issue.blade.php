<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">

            <span class="h5">
                {!! $issue->getCreatedAtTagLine() !!}
            </span>

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

        <div class="row">

            <hr>

            <div class="col-md-12">

                <span class="btn-group">
                    @can('edit', $issue)
                        <a
                                class="btn btn-default btn-sm"
                                href="{{ route('issues.edit', [$issue->getKey()]) }}">
                            <i class="fa fa-edit"></i>
                            Edit
                        </a>
                    @endcan

                    @can('destroy', $issue)
                        <a
                                class="btn btn-default btn-sm"
                                data-post="DELETE"
                                data-title="Delete Comment?"
                                data-message="Are you sure you want to delete this comment?"
                                href="{{ route('issues.destroy', [$issue->getKey()]) }}">
                            <i class="fa fa-times"></i>
                            Delete
                        </a>
                    @endcan
                </span>

            </div>

        </div>

    </div>

</div>
