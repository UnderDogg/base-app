<ul class="nav navbar-left navbar-nav">
    @can('index', App\Models\GuideStep::class)
    <li class="{{ active()->route('resources.guides.steps.index') }}">
        <a href="{{ route('resources.guides.steps.index', [$guide->getSlug()]) }}">
            <i class="fa fa-list"></i>
            All Steps
        </a>
    </li>
    @endcan
    @can('create', App\Models\GuideStep::class)
    <li>
        <a href="{{ route('resources.guides.images', [$guide->getSlug()]) }}">
            <i class="fa fa-plus-circle"></i>
            Add Steps by Images
        </a>
    </li>
    <li>
        <a href="{{ route('resources.guides.steps.create', [$guide->getSlug()]) }}">
            <i class="fa fa-plus-circle"></i>
            New Step
        </a>
    </li>
    @endcan
    @can('edit', App\Models\Guide::class)
    <li>
        <a href="{{ route('resources.guides.edit', [$guide->getSlug()]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
    </li>
    @endcan
    @can('destroy', App\Models\Guide::class)
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
    @endcan
    <li>
        <a href="{{ route('resources.guides.favorite', [$guide->getSlug()]) }}">
            {!! $guide->getFavoriteIcon() !!}
            Favorite
        </a>
    </li>
</ul>
