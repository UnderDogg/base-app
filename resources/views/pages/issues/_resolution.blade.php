<div class="card answer">

    <div class="col-md-12 answer-heading">

        <h4>
            <i class="fa fa-check-square"></i>
            Answer
        </h4>

    </div>

    <div class="card-heading image">

        <img src="{{ route('profile.avatar.download', [$comment->user->id]) }}" alt=""/>

        <div class="card-heading-header">

            <h3>{{ $comment->user->name }}</h3>

            <span>{!! $comment->created_at_human !!}</span>

        </div>

    </div>

    <div class="card-body">
        <p>
            {!! $comment->content_from_markdown !!}
        </p>
    </div>

</div>
