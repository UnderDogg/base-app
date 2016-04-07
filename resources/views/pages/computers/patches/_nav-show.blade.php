<ul class="nav navbar-left navbar-nav">

    <li>
        <a href="{{ route('computers.patches.edit', [$computer->id, $patch->id]) }}">
            <i class="fa fa-edit"></i> Edit
        </a>
    </li>

    <li>
        <a
                data-post="DELETE"
                data-title="Are you sure?"
                data-message="Are you sure you want to delete this patch?"
                href="{{ route('computers.patches.destroy', [$computer->id, $patch->id]) }}"
        >
            <i class="fa fa-trash"></i> Delete
        </a>
    </li>

</ul>
