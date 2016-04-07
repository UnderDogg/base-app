@if ($comment->files->count() > 0)

    <div class="well">

        @foreach($comment->files as $file)

            <a class="btn btn-info btn-xs btn-attachment" href="{{ route('issues.comments.attachments.show', [$issue->id, $comment->id, $file->uuid]) }}">
                {!! $file->icon !!}

                {{ $file->name }}
            </a>

        @endforeach

    </div>

    <hr>

@endif
