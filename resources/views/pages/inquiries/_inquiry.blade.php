<div class="card ticket">

    <div class="col-md-12 ticket-heading">

        <h4>
            <span class="text-muted">{{ $inquiry->getHashId() }}</span>
            {{ $inquiry->title }}
        </h4>

    </div>

    <div class="card-heading image">

        <img src="{{ route('profile.avatar.download', [$inquiry->user->getKey()]) }}" alt="{{ $inquiry->user->fullname }}'s Profile Avatar"/>

        <div class="card-heading-header">

            <h3>{{ $inquiry->user->fullname }}</h3>

            <span>{!! $inquiry->createdAtHuman() !!}</span>

        </div>

    </div>

    <div class="card-body">
        <p>
            {!! $inquiry->getDescriptionFromMarkdown() !!}
        </p>

        {{--
         We'll make sure a resolution exists and that we have more than
         one comment before display the resolution here.
         --}}
        @if(isset($resolution) && count($inquiry->comments) > 1)

            {{-- We'll also make sure that the first comment is not a resolution. --}}
            @if(!$inquiry->comments->first()->isResolution())

                <hr>

                <p>
                    @include('pages.issues._resolution', ['comment' => $resolution])
                </p>

            @endif

        @endif
    </div>

    <div class="card-actions pull-right">

        @can('edit', $inquiry)
        <a
                class="btn btn-default btn-sm"
                href="{{ route('inquiries.edit', [$inquiry->getKey()]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
        @endcan

        @can('destroy', $inquiry)
        <a
                class="btn btn-default btn-sm"
                data-post="DELETE"
                data-title="Delete Ticket?"
                data-message="Are you sure you want to delete this request?"
                href="{{ route('inquiries.destroy', [$inquiry->getKey()]) }}">
            <i class="fa fa-times"></i>
            Delete
        </a>
        @endcan

    </div>

    <div class="clearfix"></div>

</div>
