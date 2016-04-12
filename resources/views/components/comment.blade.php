@extends('components.card')

@section('card.type') {{ ($comment->resolution ? 'card-answer' : null) }} @overwrite

@section('card.id'){{ "comment-{$comment->id}" }}@overwrite

@section('card.title')

    @if($comment->resolution)

        <div class="col-md-12 card-title card-answer-heading">

            <h4>
                Answer

                <span class="pull-right text-muted">
                    <i class="fa fa-check"></i>
                </span>
            </h4>

        </div>

    @else

        <div class="col-md-12 card-title">

            <h4>
                <span class="pull-right text-muted">
                    <i class="fa fa-comment"></i>
                </span>
            </h4>

            <div class="clearfix"></div>

        </div>

    @endif

@overwrite

@section('card.heading')

    @section('comment.heading')

        <img class="avatar" src="{{ route('profile.avatar.download', [$comment->user->id]) }}" alt=""/>

        <div class="card-heading-header">

            <h3>{{ $comment->user->name }}</h3>

            <span>{!! $comment->created_at_human !!}</span>

        </div>

    @show

@overwrite

@section('card.body')

    @section('comment.body')

        <p>{!! $comment->content_from_markdown !!}</p>

    @show

@overwrite

@section('card.actions')

    @yield('comment.actions')

@overwrite
