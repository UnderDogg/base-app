<ul class="nav navbar-left navbar-nav">

    <li>
        <a href="{{ route('inquiries.categories.create') }}">
            <i class="fa fa-plus-square"></i> New Category
        </a>
    </li>

    @if(isset($category) && $category->exists)
        <li>
            <a href="{{ route('inquiries.categories.create', [$category->id]) }}">
                <i class="fa fa-plus-square"></i> New Sub-Category Here
            </a>
        </li>

        <li>
            <a href="{{ route('inquiries.categories.edit', [$category->id]) }}">
                <i class="fa fa-edit"></i> Edit
            </a>
        </li>

        <li>
            <a
                    href="{{ route('inquiries.categories.destroy', [$category->id]) }}"
                    data-post="DELETE"
                    data-title="Are you sure?"
                    data-message="Are you sure you want to delete this category?"
            >
                <i class="fa fa-trash"></i> Delete
            </a>
        </li>
    @endif

</ul>
