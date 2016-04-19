@extends('components.card')

@section('card.type') card-primary @overwrite

@section('card.id'){{ "issue-$issue->id" }}@overwrite

@section('card.title')

    <div class="card-title col-md-12">

        <h4>

            <span class="text-muted">{{ $issue->hash_id }}</span>

            {{ $issue->title }}

            <span class="pull-right text-muted">
                <i class="fa fa-ticket"></i>
            </span>

        </h4>

    </div>

@overwrite

@section('card.heading')

    <img class="avatar" src="{{ route('profile.avatar.download', [$issue->user->id]) }}" alt="{{ $issue->user->name }}'s Profile Avatar"/>

    <div class="card-heading-header">

        <h3>{{ $issue->user->name }}</h3>

        <span>{!! $issue->created_at_human !!}</span>

    </div>

@overwrite

@section('card.body')

    <p>
        {!! $issue->description_from_markdown !!}
    </p>

    {{--
     We'll make sure a resolution exists and that we have more than
     one comment before display the resolution here.
     --}}
    @if(isset($resolution) && count($issue->comments) > 1)

        {{-- We'll also make sure that the first comment is not a resolution. --}}
        @if(!$issue->comments->first()->resolution)

            <hr>

            @include('pages.issues._resolution', ['comment' => $resolution])

        @endif

    @endif

    <!-- Attachments -->
    <div class="hidden-print">
        @include('pages.issues._files')
    </div>

@overwrite

@section('card.actions')

    <div class="hidden-print">

        @if(\App\Policies\IssuePolicy::edit(auth()->user(), $issue))

            <a
                    class="btn btn-default btn-sm"
                    href="{{ route('issues.edit', [$issue->id]) }}">
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
                    href="{{ route('issues.destroy', [$issue->id]) }}">
                <i class="fa fa-times"></i>
                Delete
            </a>

        @endif

        @include('pages.issues._form-labels')

        @include('pages.issues._form-users')

    </div>

@overwrite

