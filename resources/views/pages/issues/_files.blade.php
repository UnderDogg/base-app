@if ($issue->files->count() > 0)

    <i class="fa fa-paperclip"></i>

    @foreach($issue->files as $file)

        <a class="btn btn-default btn-xs" href="{{ route('issues.attachments.show', [$issue->getKey(), $file->uuid]) }}">
            {!! $file->icon !!}

            {{ $file->name }}
        </a>

    @endforeach

    <hr>

@endif
