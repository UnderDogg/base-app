@if ($patch->files->count() > 0)

    <div class="well">

        @foreach($patch->files as $file)

            <a class="btn btn-info btn-xs btn-attachment" href="{{ '' }}">
                {!! $file->icon !!}

                {{ $file->name }}
            </a>

        @endforeach

    </div>

    <hr>

@endif
