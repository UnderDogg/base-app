<div class="panel panel-{{  $record->color }}">

    <div class="panel-heading">

        {{ $record->title }}

        <span class="pull-right">
            {{ $record->created_at_human }}
        </span>

    </div>

    @if($record->description)

        <div class="panel-body">
            {!! $record->description !!}
        </div>

    @endif

</div>
