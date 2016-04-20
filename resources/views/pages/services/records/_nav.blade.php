<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('services.records.index') }}">
        <a href="{{ route('services.records.index', [$service->id]) }}">
            <i class="fa fa-list"></i> All Records
        </a>
    </li>

    <li>
        <a href="{{ route('services.records.create', [$service->id]) }}">
            <i class="fa fa-plus"></i> New Record
        </a>
    </li>

    <li>
        <a href="{{ route('services.edit', [$service->id]) }}">
            <i class="fa fa-pencil-square-o"></i> Edit
        </a>
    </li>

    <li>
        <a href="{{ route('services.destroy', [$service->id]) }}"
           data-post="DELETE"
           data-title="Delete Service?"
           data-message="Are you sure you want to delete this service? It cannot be recovered."
        >
            <i class="fa fa-trash"></i>
            Delete
        </a>
    </li>

</ul>
