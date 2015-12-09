<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('resources.guides.steps.index') }}">
        <a href="{{ route('resources.guides.steps.index', [$guide->getSlug()]) }}">
            All Steps
        </a>
    </li>
    <li>
        <a href="{{ route('resources.guides.images', [$guide->getSlug()]) }}">
            <i class="fa fa-plus"></i>
            Add Steps by Images
        </a>
    </li>
    <li>
        <a href="{{ route('resources.guides.steps.create', [$guide->getSlug()]) }}">
            <i class="fa fa-plus"></i>
            New Step
        </a>
    </li>
    <li>
        <a href="{{ route('resources.guides.edit', [$guide->getSlug()]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
    </li>
    <li>
        <a href="{{ route('resources.guides.destroy', [$guide->getSlug()]) }}"
           data-post="DELETE"
           data-title="Delete Guide?"
           data-message="Are you sure you want to delete this guide? It cannot be recovered."
        >
            <i class="fa fa-trash"></i>
            Delete
        </a>
    </li>
</ul>
