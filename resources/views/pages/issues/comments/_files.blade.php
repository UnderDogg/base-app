@if ($comment->files->count() > 0)

    <i class="fa fa-paperclip"></i>

    @foreach($comment->files as $file)

        <a class="btn btn-default btn-xs" href="{{ route('issues.comments.attachments.show', [$issue->getKey(), $comment->getKey(), $file->uuid]) }}">
            {!! $file->icon !!}

            {{ $file->name }}
        </a>

    @endforeach

    <hr>

@endif
