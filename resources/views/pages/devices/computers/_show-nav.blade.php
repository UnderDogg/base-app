<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ active()->route('devices.computers.show') }}">
        <a title="Computer Details" href="{{ route('devices.computers.show', [$computer->getKey()]) }}">
            <i class="fa fa-info-circle"></i>
            Details
        </a>
    </li>
    <li role="presentation">
        <a title="Computer Hard Disks" href="#">
            <i class="fa fa-hdd-o"></i>
            Disks
        </a>
    </li>
    <li role="presentation">
        <a title="Computer Software" href="#">
            <i class="fa fa-terminal"></i>
            Software
        </a>
    </li>
    <li role="presentation" class="{{ active()->route('devices.computers.settings.edit') }}">
        <a title="Computer Settings" href="{{ route('devices.computers.settings.edit', [$computer->getKey()]) }}">
            <i class="fa fa-cogs"></i>
            Settings
        </a>
    </li>
</ul>
