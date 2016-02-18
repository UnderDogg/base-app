@if ($issue->files->count() > 0)

<div class="panel panel-default">

    <div class="panel-body">

        <i class="fa fa-paperclip text-muted"></i>

        @foreach($issue->files as $file)
            <a class="btn btn-default btn-sm" href="{{ $file->complete_path }}">
                {!! $file->icon !!}

                {{ $file->name }}
            </a>
        @endforeach

    </div>

</div>

@endif
