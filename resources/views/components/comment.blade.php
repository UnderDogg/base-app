@extends('components.card')

@section('card.type') {{ ($comment->resolution ? 'card-answer' : null) }} @overwrite

@section('card.id'){{ "comment-{$comment->id}" }}@overwrite

@section('card.title')

    @if($comment->resolution)

        <div class="col-md-12 card-title card-answer-heading">

            <h4>

                Answer

                <a href="#comment-{{ $comment->id }}">

                    <span class="pull-right text-muted">
                        <i class="fa fa-check"></i>
                    </span>

                </a>

            </h4>

        </div>

    @else

        <div class="col-md-12 card-title">

            <h4>

                <a href="#comment-{{ $comment->id }}">

                    <span class="pull-right text-muted">
                        <i class="fa fa-comment"></i>
                    </span>

                </a>

            </h4>

            <div class="clearfix"></div>

        </div>

    @endif

@overwrite

@section('card.heading')

    <img class="hidden-xs avatar" src="{{ route('profile.avatar.download', [$comment->user->id]) }}" alt=""/>

    <div class="card-heading-header">

        <h3>{{ $comment->user->name }}</h3>

        <span>
            Commented {{ $comment->created_at_human }}

            @if ($comment->revisions()->count() > 0)

               - Edited {{ $comment->revisions->last()->created_at_human }}

            @endif

        </span>

    </div>

@overwrite

@section('card.body')

    @yield('comment.body')

@overwrite

@section('card.actions')

    @yield('comment.actions')

@overwrite
