@extends('pages.computers.show')

@section('show.panel.title')

    Hard Disks

    <span class="pull-right btn-group">

        <a
                class="btn btn-xs btn-warning"
                data-post="POST"
                data-title="Synchronize hard disks?"
                data-message="Are you sure you want to synchronize this computers hard disks?"
                href="{{ route('computers.disks.sync', [$computer->getKey()]) }}"
                >
            <i class="fa fa-refresh"></i>
            Synchronize
        </a>

    </span>

@endsection

@section('show.panel.body')

    {!! $disks !!}

    <hr>

    <div id="disks-div"></div>

    @if($diskGraph && $diskGraph instanceof \Khill\Lavacharts\Charts\LineChart)

        {!! Lava::render('LineChart', 'Disks', 'disks-div') !!}

    @endif

@endsection
