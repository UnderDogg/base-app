<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ active()->route('devices.computers.show') }}">
        <a title="Computer Details" href="{{ route('devices.computers.show', [$computer->getKey()]) }}">
            <i class="fa fa-info-circle"></i>
            Details
        </a>
    </li>
    <li role="presentation" class="{{ active()->route('devices.computers.disks.*') }}">
        <a title="Computer Hard Disks" href="{{ route('devices.computers.disks.index', [$computer->getKey()]) }}">
            <i class="fa fa-hdd-o"></i>
            Disks
        </a>
    </li>
    <li role="presentation" class="{{ active()->route('devices.computers.cpu.*') }}">
        <a title="Computer CPU Details" href="{{ route('devices.computers.cpu.index', [$computer->getKey()]) }}">
            <i class="fa fa-line-chart"></i>
            CPU
        </a>
    </li>
    <li role="presentation">
        <a title="Computer Software" href="#">
            <i class="fa fa-terminal"></i>
            Software
        </a>
    </li>
    <li role="presentation" class="{{ active()->route('devices.computers.access.edit') }}">
        <a title="Computer Settings" href="{{ route('devices.computers.access.edit', [$computer->getKey()]) }}">
            <i class="fa fa-cogs"></i>
            Access
        </a>
    </li>
</ul>
