<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('devices.computers.show') }}">
        <a title="Computer Details" href="{{ route('devices.computers.show', [$computer->getKey()]) }}">
            <i class="fa fa-info-circle"></i>
            Details
        </a>
    </li>

    <li class="{{ active()->route('devices.computers.patches.show') }}">
        <a title="Computer Details" href="#">
            <i class="fa fa-medkit"></i>
            Patches
        </a>
    </li>

    <li class="{{ active()->route('devices.computers.disks.*') }}">
        <a title="Computer Hard Disks" href="{{ route('devices.computers.disks.index', [$computer->getKey()]) }}">
            <i class="fa fa-hdd-o"></i>
            Disks
        </a>
    </li>

    <li class="{{ active()->route('devices.computers.cpu.*') }}">
        <a title="Computer CPU Details" href="{{ route('devices.computers.cpu.index', [$computer->getKey()]) }}">
            <i class="fa fa-line-chart"></i>
            CPU
        </a>
    </li>

    <li>
        <a title="Computer Software" href="#">
            <i class="fa fa-terminal"></i>
            Software
        </a>
    </li>

    <li class="{{ active()->route('devices.computers.access.edit') }}">
        <a title="Computer Settings" href="{{ route('devices.computers.access.edit', [$computer->getKey()]) }}">
            <i class="fa fa-cogs"></i>
            Access
        </a>
    </li>

</ul>
