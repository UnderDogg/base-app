<div class="card ticket">

    <div class="col-md-12 ticket-heading">

        <h4>
            <span class="text-muted">{{ $issue->hash_id }}</span>
            {{ $issue->title }}

            @foreach($issue->labels as $label)
                {!! $label->display_large !!}
            @endforeach

            @foreach($issue->users as $user)
                {!! $user->label_large !!}
            @endforeach

            <span class="pull-right text-muted">
                <i class="fa fa-ticket"></i>
            </span>
        </h4>

    </div>

    <div class="card-heading image">

        <img src="{{ route('profile.avatar.download', [$issue->user->getKey()]) }}" alt="{{ $issue->user->fullname }}'s Profile Avatar"/>

        <div class="card-heading-header">

            <h3>{{ $issue->user->fullname }}</h3>

            <span>{!! $issue->created_at_human !!}</span>

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
            @if(!$issue->comments->first()->resolution)

            <hr>

            <p>
                @include('pages.issues._resolution', ['comment' => $resolution])
            </p>

            @endif

        @endif
    </div>

    <div class="card-actions pull-right">

        @if(\App\Policies\IssuePolicy::edit(auth()->user(), $issue))
            <a
                    class="btn btn-default btn-sm"
                    href="{{ route('issues.edit', [$issue->getKey()]) }}">
                <i class="fa fa-edit"></i>
                Edit
            </a>
        @endif

        @if(\App\Policies\IssuePolicy::destroy(auth()->user(), $issue))
            <a
                    class="btn btn-default btn-sm"
                    data-post="DELETE"
                    data-title="Delete Ticket?"
                    data-message="Are you sure you want to delete this ticket?"
                    href="{{ route('issues.destroy', [$issue->getKey()]) }}">
                <i class="fa fa-times"></i>
                Delete
            </a>
        @endif

        @include('pages.issues._form-labels')

        @include('pages.issues._form-users')

    </div>

    <div class="clearfix"></div>

</div>
