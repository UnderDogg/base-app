<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('services.records.index') }}">
        <a href="{{ route('services.records.index', [$service->getKey()]) }}">
            <i class="fa fa-list"></i> All Records
        </a>
    </li>
    <li>
        <a href="{{ route('services.records.create', [$service->getKey()]) }}">
            <i class="fa fa-plus"></i> New Record
        </a>
    </li>
</ul>
