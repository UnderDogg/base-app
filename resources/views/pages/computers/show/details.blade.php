@extends('pages.computers.show')

@section('show.panel.title')

Details

@endsection

@section('show.panel.body')

    <label>Type</label>

    <p>
        @if($computer->type)
            {{ $computer->type->name }}
        @else
            <em>None</em>
        @endif
    </p>

    <label>Description</label>

    <p>
        @if($computer->description)
            {{ $computer->description }}
        @else
            <em>None</em>
        @endif
    </p>

    <label>Model</label>

    <p>
        @if($computer->model)
            {{ $computer->model }}
        @else
            <em>None</em>
        @endif
    </p>

    <label>Operating System</label>

    <p>
        @if($computer->os)
            {{ $computer->os->full_name }}
        @else
            <em>None</em>
        @endif
    </p>

    <hr>

    <h3>Online Status</h3>

    <p>
        <a
                class="btn btn-xs btn-default"
                data-post="POST"
                data-title="Check status?"
                data-message="Are you sure you want to check the status of this computer?"
                href="{{ route('computers.status.check', [$computer->id]) }}"
        >
            <i class="fa fa-refresh"></i>
        </a>

        {!! $computer->online_status !!}
    </p>

    <div id="status-chart"></div>

    {!! Lava::render('LineChart', 'Status', 'status-chart') !!}

@endsection
