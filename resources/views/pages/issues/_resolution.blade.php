<div class="card answer">

    <div class="col-md-12 answer-heading">

        <h4>
            <i class="fa fa-check-square"></i>
            Best Answer
        </h4>

    </div>

    <div class="card-heading image">

        <img src="{{ route('profile.avatar.download', [$comment->user->getKey()]) }}" alt=""/>

        <div class="card-heading-header">

            <h3>{{ $comment->user->fullname }}</h3>

            <span>{!! $comment->createdAtHuman() !!}</span>

        </div>

    </div>

    <div class="card-body">
        <p>
            {!! $comment->getContentFromMarkdown() !!}
        </p>
    </div>

</div>
