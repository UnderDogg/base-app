@if ($issue->files->count() > 0)

    <div class="well">

        @foreach($issue->files as $file)

            <a class="btn btn-info btn-xs btn-attachment" href="{{ route('issues.attachments.show', [$issue->id, $file->uuid]) }}">
                {!! $file->icon !!}

                {{ $file->name }}
            </a>

        @endforeach

    </div>

    <hr>

@endif
