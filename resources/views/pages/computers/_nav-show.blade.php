<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('computers.show') }}">
        <a title="Computer Details" href="{{ route('computers.show', [$computer->id]) }}">
            <i class="fa fa-info-circle"></i>
            Details
        </a>
    </li>

    <li>
        <a href="{{ route('computers.edit', [$computer->id]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
    </li>

    <li>
        <a
                data-post="DELETE"
                data-title="Delete Computer?"
                data-message="Are you sure you want to delete this computer?"
                href="{{ route('computers.destroy', [$computer->id]) }}"
        >
            <i class="fa fa-trash"></i>
            Delete
        </a>
    </li>

</ul>
