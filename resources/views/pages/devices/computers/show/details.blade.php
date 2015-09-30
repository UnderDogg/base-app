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
            href="{{ route('devices.computers.delete', [$computer->getKey()]) }}"
            >
        Delete
    </a>
</span>

@stop

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

<label>Access</label>
<p>{!! $computer->getAccessChecks() !!}</p>

@stop
