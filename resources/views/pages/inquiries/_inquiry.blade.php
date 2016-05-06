<div class="card card-primary">

    <!-- Request Title. -->
    <div class="card-title col-md-12">

        <h4>

            <span class="text-muted">{{ $inquiry->hash_id }}</span>

            {{ $inquiry->title }}

            <span class="pull-right text-muted">
                <i class="fa fa-question-circle"></i>
            </span>

        </h4>


    </div>

    <div class="card-heading image">

        <img class="avatar" src="{{ route('profile.avatar.download', [$inquiry->user->id]) }}" alt="{{ $inquiry->user->name }}'s Profile Avatar"/>

        <div class="card-heading-header">

            <h3>{{ $inquiry->user->name }}</h3>

            <span>{!! $inquiry->created_at_human !!}</span>

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
            @if(!$inquiry->comments->first()->resolution)

                <hr>

                <p>
                    @include('pages.issues._resolution', ['comment' => $resolution])
                </p>

            @endif

        @endif
    </div>

    <div class="card-actions pull-right">

        @can('inquiries.edit', [$inquiry])
            <a
                    class="btn btn-default btn-sm"
                    href="{{ route('inquiries.edit', [$inquiry->id]) }}">
                <i class="fa fa-edit"></i>
                Edit
            </a>
        @endcan

        @can('inquiries.destroy', [$inquiry])
            <a
                    class="btn btn-default btn-sm"
                    data-post="DELETE"
                    data-title="Delete Ticket?"
                    data-message="Are you sure you want to delete this request?"
                    href="{{ route('inquiries.destroy', [$inquiry->id]) }}">
                <i class="fa fa-times"></i>
                Delete
            </a>
        @endcan

    </div>

    <div class="clearfix"></div>

</div>
