<div class="card">

    <div class="card-heading image">

        <img src="{{ route('profile.avatar.download', [$issue->user->getKey()]) }}" alt="{{ $issue->user->fullname }}'s Profile Avatar"/>

        <div class="card-heading-header">

            <h3>{{ $issue->user->fullname }}</h3>

            <span>{!! $issue->createdAtHuman() !!}</span>

        </div>

    </div>

    <div class="card-body">
        <p>
            {!! $issue->getDescriptionFromMarkdown() !!}
        </p>

        {{--
         We'll make sure a resolution exists and that we have more than
         one comment before display the resolution here.
         --}}
        @if(isset($resolution) && count($issue->comments) > 1)

            {{-- We'll also make sure that the first comment is not a resolution. --}}
            @if(!$issue->comments->first()->isResolution())

            <hr>

            <p>
                @include('pages.issues._resolution', ['comment' => $resolution])
            </p>

            @endif

        @endif
    </div>

    <div class="card-actions">
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
                data-title="Delete Ticket?"
                data-message="Are you sure you want to delete this ticket?"
                href="{{ route('issues.destroy', [$issue->getKey()]) }}">
            <i class="fa fa-times"></i>
            Delete
        </a>
        @endcan
    </div>

</div>
