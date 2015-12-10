@extends('pages.devices.computers.show')

@section('show.panel.title')

Details

<span class="pull-right btn-group">
    <a class="btn btn-xs btn-warning" href="{{ route('devices.computers.edit', [$computer->getKey()]) }}">
        Edit
    </a>
    <a
            class="btn btn-xs btn-danger"
            data-post="DELETE"
            data-title="Delete Computer?"
            data-message="Are you sure you want to delete this computer?"
            href="{{ route('devices.computers.destroy', [$computer->getKey()]) }}"
            >
        Delete
    </a>
</span>

@stop

@section('show.panel.body')

<label>Status</label>
<p>
    {!! $computer->getOnlineStatus() !!}
</p>

<p>
    <a
            class="btn btn-xs btn-default"
            data-post="POST"
            data-title="Check status?"
            data-message="Are you sure you want to check the status of this computer?"
            href="{{ route('devices.computers.status.check', [$computer->getKey()]) }}"
            >
        <i class="fa fa-refresh"></i> Refresh Status
    </a>
</p>

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

<label>Access</label>
<p>{!! $computer->getAccessChecks() !!}</p>

@stop
