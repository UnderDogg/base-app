<ul class="nav navbar-left navbar-nav">

    <li>
        <a href="{{ route('inquiries.categories.create') }}">
            <i class="fa fa-plus-square"></i> New Category
        </a>
    </li>

    @if(isset($category) && $category->exists)
        <li>
            <a href="{{ route('inquiries.categories.create', [$category->getKey()]) }}">
                <i class="fa fa-plus-square"></i> New Sub-Category Here
            </a>
        </li>

        <li>
            <a href="{{ route('inquiries.categories.edit', [$category->getKey()]) }}">
                <i class="fa fa-edit"></i> Edit
            </a>
        </li>

        <li>
            <a href="{{ route('inquiries.categories.edit', [$category->getKey()]) }}">
                <i class="fa fa-edit"></i> Edit
            </a>
        </li>
    @endif

</ul>
