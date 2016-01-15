@extends('pages.devices.computers.show')

@section('show.panel.title')

    CPU Usage

@endsection

@section('show.panel.body')

    <div id="cpu-div"></div>

    @if(isset($cpu) && $cpu instanceof Khill\Lavacharts\Charts\GaugeChart)
        @gaugechart('cpu', 'cpu-div')

        <script>
            window.setInterval(function () {
                $.getJSON('{{ route('devices.computers.cpu.json', [$computer->getKey()]) }}', function (dataTableJson) {
                    lava.loadData('cpu', dataTableJson);
                });
            }, 1000);
        </script>
    @endif

@endsection
